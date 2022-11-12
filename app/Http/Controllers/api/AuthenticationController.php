<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


// use Validator;
// use Illuminate\Support\Facades\Crypt;

class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "full_name" => 'requird',
            "brand_name" => 'requird',
            "city" => 'required',
            "vendor" => 'required',
            "phone" => 'required',
            "email" => 'required|email|unique:users',
            "password" => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json(['status' => "error", 'errors' => $validator->errors()]);
        } else {

            $validData = $validator->validated();
            // $validData['password'] = Crypt::encrypt($request->password);
            return response()->json($validData);
            if (User::create($validData)) {
                return response()->json(['status' => "success", "message" => "Vendor created successfully"], 200);
            }
        }
    }
}
