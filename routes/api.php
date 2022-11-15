<?php

use App\Http\Controllers\api\AuthenticationController;
use App\Http\Controllers\api\BlogController;
use App\Http\Controllers\api\RealWeddingController;
use App\Http\Controllers\api\SettingsController;
use App\Http\Controllers\api\VendorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Settings route
Route::get('city', [SettingsController::class, 'getCity']);
Route::get('vendor', [SettingsController::class, 'getVendors']);

// authintication route
Route::post('register', [AuthenticationController::class, 'register']);
Route::post('verify-account', [AuthenticationController::class, 'verifyAccount']);
Route::post('login', [AuthenticationController::class, 'login']);
Route::post('forgot-password', [AuthenticationController::class, 'forgotPassword']);
Route::post('save-new-password', [AuthenticationController::class, 'setNewPassword']);


// Blog route
Route::get('blog/{limit?}', [BlogController::class, 'index']);
Route::get('blog-page', [BlogController::class, 'page']);
Route::get('blog/{slug}', [BlogController::class, 'show']);
Route::get('blog/author', [BlogController::class, 'author']);
Route::get('blog/category', [BlogController::class, 'category']);

// Blog route
Route::get('real-weeding/{limit?}', [RealWeddingController::class, 'index']);
Route::get('real-weeding-page', [RealWeddingController::class, 'page']);
Route::get('real-weeding/{slug}', [RealWeddingController::class, 'show']);
Route::get('real-weeding/author', [RealWeddingController::class, 'author']);
Route::get('real-weeding/category', [RealWeddingController::class, 'category']);


// middleware verification
Route::group(['middleware' => ['verify.apitoken']], function () {
    // logout
    Route::post('logout', [AuthenticationController::class, 'logout']);

    // Vendor info API
    Route::post("/update-vendor-information", [VendorController::class, 'update']);
    Route::post("/upload-vendor-project", [VendorController::class, 'uploadPortfolio']);
    Route::get("/get-vendor-information", [VendorController::class, 'getInfo']);
    Route::get("/get-vendor-projects", [VendorController::class, 'getProject']);
});
