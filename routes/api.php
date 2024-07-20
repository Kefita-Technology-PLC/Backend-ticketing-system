<?php

use App\Http\Controllers\Api\EmailVerificationController;
use App\Http\Controllers\Api\NewPasswordController;
use App\Http\Controllers\Api\SessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [SessionController::class, 'register']);

Route::post('/login', [SessionController::class, 'login'])->middleware('auth:sanctum', 'verified');

Route::post('/logout', [SessionController::class, 'logout'])->middleware('auth:sanctum', 'verified');

Route::get('/verified-middleware', function(){
    return response()->json([
        'message'=> 'The email account is already confirmed now you are able to see this message...',
    ], 201);
})->middleware('auth:sanctum', 'verified');

Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail'])->middleware('auth:sanctum');

Route::post('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:sanctum');

Route::post('forgot-password', [NewPasswordController::class, 'forgotPassword']);

Route::post('reset-password', [NewPasswordController::class, 'reset']);