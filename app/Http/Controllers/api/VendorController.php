<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Profile;
use App\Models\User;
use App\Models\VendorPortfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    public function update(Request $request)
    {

        $token = $request->header("x-auth-token");
        $decodedToken = decodeToken($token);

        $validator = Validator::make($request->all(), [
            "website_link" => 'nullable|string|url',
            "facebook_link" => 'nullable|string|url',
            "instagram_link" => 'nullable|string|url',
            "youtube_url" => 'nullable',
            "additional_information" => 'nullable|string',
            "address" => 'nullable|string',
            "additional_details" => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => "error", 'errors' => $validator->errors()]);
        } else {
            $validData = $validator->validate();
            $validData['user_id'] = $decodedToken->uid;
            $validData['additional_details'] = json_decode($request->additional_details);
            Profile::updateOrCreate($validData);
            return response()->json(['status' => "success", 'message' => "Information updated successfully"], 200);
        }

        return response()->json([$decodedToken]);
    }

    public function getInfo(Request $request)
    {
        $token = $request->header("x-auth-token");
        $decodedToken = decodeToken($token);
        $userId = $decodedToken->uid;
        $findUserProfile = User::with('profile')->find($userId);
        return response()->json(['status' => "success", 'data' => $findUserProfile]);
    }

    public function uploadPortfolio(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'images' => 'required|array',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => "error", "errors" => $validator->errors()], 401);
        } else {
            $token = $request->header("x-auth-token");
            $decodedToken = decodeToken($token);
            $userId = $decodedToken->uid;
            foreach ($request->file('images') as $key => $image) {
                $new_name = rand() . '.' . $image->getClientOriginalExtension();
                $dir = public_path('storage/files/' . $userId);
                if (!file_exists($dir)) {
                    mkdir($dir);
                }
                if ($image->move($dir, $new_name)) {
                    VendorPortfolio::create(['user_id' => $userId, 'title' => $new_name, 'photo' => 'storage/files/' . $userId . '/' . $new_name]);
                }
            }
            return response()->json(['status' => "success", "message" => "Projects uploaded successfully."], 200);
        }
    }

    public function getProject(Request $request)
    {
        $token = $request->header("x-auth-token");
        $decodedToken = decodeToken($token);
        $userId = $decodedToken->uid;
        $data = VendorPortfolio::where('user_id', $userId)->where('album', 0)->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function uploadAlbum(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'images' => 'required|array',
            'title' => "required"
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => "error", "errors" => $validator->errors()], 401);
        } else {
            $token = $request->header("x-auth-token");
            $decodedToken = decodeToken($token);
            $userId = $decodedToken->uid;
            $createAlbum = Album::create(['title' => $request->title, 'user_id' => $userId]);
            if ($createAlbum->id) :
                foreach ($request->file('images') as $key => $image) {
                    $new_name = rand() . '.' . $image->getClientOriginalExtension();
                    $dir = public_path('storage/files/' . $userId);
                    if (!file_exists($dir)) {
                        mkdir($dir);
                    }
                    if ($image->move($dir, $new_name)) {
                        VendorPortfolio::create(['user_id' => $userId, 'album_id' => $createAlbum->id, 'album' => true, 'title' => $new_name, 'photo' => 'storage/files/' . $userId . '/' . $new_name]);
                    }
                }
            endif;
            return response()->json(['status' => "success", "message" => "Album created successfully."], 200);
        }
    }

    public function deleteProject(Request $request, $id)
    {
        $token = $request->header("x-auth-token");
        $decodedToken = decodeToken($token);
        $userId = $decodedToken->uid;
        $findProject = VendorPortfolio::find($id);
        if ($findProject) {
            $findProject->delete();
            $dir = public_path('storage/files/' . $userId . '/' . $findProject->title);
            if (file_exists($dir)) {
                unlink($dir);
            }
            return response()->json(['status' => "success", "message" => "Projects deleted successfully."], 200);
        } else {
            return response()->json(['status' => "error", "message" => "Not found."], 401);
        }
    }

    public function getAlbum(Request $request)
    {
        $token = $request->header("x-auth-token");
        $decodedToken = decodeToken($token);
        $userId = $decodedToken->uid;
        $data = Album::with('image')->get();
        return response()->json(['status' => "success", "data" => $data], 200);
        // Album
    }
}
