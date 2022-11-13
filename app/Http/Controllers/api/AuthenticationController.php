<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Mail\OTPmail;
use App\Models\AuthToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use \Firebase\JWT\JWT;

class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "full_name" => 'string',
            "brand_name" => 'string',
            "city" => 'required',
            "vendor" => 'required',
            "phone" => 'required|unique:users',
            "email" => 'required|email|unique:users',
            "password" => 'required',
            "role" => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => "error", 'errors' => $validator->errors()]);
        } else {

            if ($request->role == 1) {
                return response()->json(['status' => "error", "message" => "Can\'t accept this role, Please send me 2 for vendor and 3 for user."], 200);
            }

            $oneTimeOtp = rand(1000, 9999);
            $validData = $validator->validated();
            $validData['password'] = Hash::make($request->password);
            $validData['otp'] = $oneTimeOtp;

            $mailDetails = [];
            $mailDetails['title'] = "Hi, $request->full_name . Welcome to " . env("APP_NAME");
            $mailDetails["body"] = "Your One Time Password (OTP) for verification is " . $oneTimeOtp . " Do\'t share your OTP with others.";
            $sendMail = $this->sendOTPmail($request->email, $mailDetails);
            if ($sendMail) {
                User::create($validData);
                return response()->json(['status' => "success", "message" => "An Email with verification code was just send to you."], 200);
            } else {
                return response()->json(['status' => "error", "message" => "Something went wrong, please try again later."], 200);
            }
        }
    }

    public function sendOTPmail($toAddress, array $details)
    {
        if (\Mail::to($toAddress)->send(new OTPmail($details))) {
            return true;
        }
        return false;
    }

    public function verifyAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => "error", 'errors' => $validator->errors()]);
        } else {
            $findUser = User::where('email', $request->email)->first();
            if ($findUser) {
                if ($findUser->otp == $request->otp) {
                    $findUser->otp = null;
                    $findUser->status = '1';
                    $findUser->email_verified_at = Carbon::now()->timestamp;
                    $findUser->save();
                    return response()->json(['status' => "success", 'message' => "Your account verefied successfully."]);
                } else {
                    return response()->json(['status' => "error", 'message' => "OTP doesn\'t match."]);
                }
            } else {
                return response()->json(['status' => "error", 'message' => "we couldn\'t found your account. Please register first."]);
            }
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'password' => 'required',
                'user_id' => 'required'
            ],
            [
                'user_id.required' => "Please insert email or phone."
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => "error", 'errors' => $validator->errors()]);
        } else {
            $loginId = $request->user_id;
            if (is_numeric($loginId)) {
                $findUser = User::where('phone', $loginId)->first();
                if ($findUser) {
                    if ($findUser->status != 1) {
                        return response()->json(["status" => "error", "message" => "Please verify your account first"]);
                    }
                    $isCorrectPassword = Hash::check($request->password, $findUser->password);
                    if ($isCorrectPassword) {
                        // here code for login with JWT token
                        $token = $this->tokenStore($findUser, $request->password);

                        return response()->json(["status" => "success", "message" => "Login success ", 'token' => $token]);
                    } else {
                        return response()->json(["status" => "error", "message" => "Password doesn\'t match"]);
                    }
                } else {
                    return response()->json(["status" => "error", "message" => "Account not found, please register first"]);
                }
            } elseif (filter_var($loginId, FILTER_VALIDATE_EMAIL)) {
                $findUser = User::where('email', $loginId)->first();
                if ($findUser) {
                    if ($findUser->status != 1) {
                        return response()->json(["status" => "error", "message" => "Please verify your account first"]);
                    }
                    $isCorrectPassword = Hash::check($request->password, $findUser->password);
                    if ($isCorrectPassword) {
                        // here code for login with JWT token
                        $token = $this->tokenStore($findUser, $request->password);
                        return response()->json(["status" => "success", "message" => "Login success", 'token' => $token]);
                    } else {
                        return response()->json(["status" => "error", "message" => "Password doesn\'t match"]);
                    }
                } else {
                    return response()->json(["status" => "error", "message" => "Account not found, please register first"]);
                }
            } else {
                return response()->json(['status' => "error", 'message' => "Please insert email or phone."]);
            }
        }
    }

    public function tokenStore(object $findUser, $password, $additional = '')
    {
        $key = env('JWT_KEY');
        $uid = $findUser->id;
        $payload = array(
            'uid' => $uid,
            "email" => $findUser->email,
            "phone" => $findUser->phone,
            "password" => $password,
            "time" => time(),
            "expire_time" => strtotime("+" . env('JWT_EXPIRE_DAY') . " Days")
        );

        $jwt = JWT::encode($payload, $key, env("JWT_ALGO"));

        $auth = new Authtoken;
        $auth->user_id = $uid;
        $auth->token = $jwt;
        $auth->expire_at = date('Y-m-d H:i:s', strtotime("+" . env('JWT_EXPIRE_DAY') . " Days"));
        $auth->additional = json_encode($additional);
        $auth->save();

        return $jwt;
    }

    public function logout(Request $request)
    {
        $token = $request->header("x-auth-token");
        AuthToken::where("token", $token)->delete();
        return response()->json(['status' => "success", 'message' => "Logout success."]);
    }
}
