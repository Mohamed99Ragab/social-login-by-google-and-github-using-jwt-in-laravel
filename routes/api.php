<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChangePasswordController;
use App\Http\Controllers\Api\PasswordResetRequestController;
use App\Http\Controllers\Api\SocialAuthController;
use App\Http\Controllers\Auth\LoginController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group(['prefix'=>'auth'],function (){

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('reset_password',[PasswordResetRequestController::class,'sendEmail']);
    Route::post('update_password',[ChangePasswordController::class,'passwordResetProcess']);

});





Route::post('/login/callback', [SocialAuthController::class,'token']);

Route::post('/login/google/callback', [SocialAuthController::class,'google']);




