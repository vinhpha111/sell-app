<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;


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

Route::get('/test', function (Request $request) {
    return response([
        'version' => '1.0.0' 
    ]);
});

Route::group(['prefix' => 'users'], function () {
    Route::post('/signup', [UserController::class, 'signUp']);
    Route::get('/check-exist', [UserController::class, 'checkExistUser']);
    Route::post('/login-otp', [UserController::class, 'loginOtp']);
    Route::get('/info', [UserController::class, 'getUserInfo'])->middleware(['auth:sanctum']);
});

Route::group([], function () {
    Route::get('/get-product-info-by-barcode', [ProductController::class, 'getProductInfoByBarcode']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
