<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\ResetPasswordController;
use App\Http\Controllers\api\ForgetPasswordController;
use App\Http\Controllers\api\ServiceController;

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


Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);


Route::post('send-reset-code', [ForgetPasswordController::class, 'sendResetCode']);
Route::post('resend-reset-code', [ForgetPasswordController::class, 'sendResetCode']);
Route::post('verify-reset-code', [ForgetPasswordController::class, 'verifyResetCode']);

Route::post('reset-password', [ResetPasswordController::class, 'setNewPassword']);



Route::get('services',[ServiceController::class,'index']);
Route::get('service/{id}',[ServiceController::class,'show']);
Route::put('service/{id}',[ServiceController::class,'update']);
Route::delete('service/{id}',[ServiceController::class,'delete']);
Route::post('services',[ServiceController::class,'store']);
