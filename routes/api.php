<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\ServiceController;
use App\Http\Controllers\api\AttributeController;
use App\Http\Controllers\api\ResetPasswordController;
use App\Http\Controllers\api\AttributeValueController;
use App\Http\Controllers\api\ForgetPasswordController;

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


Route::get('attributes', [AttributeController::class, 'index']);
Route::get('attribute/{id}', [AttributeController::class, 'show']);
Route::put('attribute/{id}', [AttributeController::class, 'update']);
Route::delete('attribute/{id}', [AttributeController::class, 'delete']);
Route::post('attributes', [AttributeController::class, 'store']);


Route::get('attribute-values', [AttributeValueController::class, 'index']);
Route::get('attribute-value/{id}', [AttributeValueController::class, 'show']);
Route::put('attribute-value/{id}', [AttributeValueController::class, 'update']);
Route::delete('attribute-value/{id}', [AttributeValueController::class, 'delete']);
Route::post('attribute-values', [AttributeValueController::class, 'store']);
