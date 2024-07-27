<?php

use App\Http\Controllers\Api\v1\SessionController;
use App\Http\Controllers\Api\v1\EmailVerificationController;
use App\Http\Controllers\Api\v1\NewPasswordController;
use App\Http\Controllers\Api\v1\StationController;
use App\Http\Controllers\Api\v1\AssociationController;
use App\Http\Controllers\Api\v1\DeploymentLineController;
use App\Http\Controllers\Api\v1\ReportController;
use App\Http\Controllers\Api\v1\TicketGeneratorController;
use App\Http\Controllers\Api\v1\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/admin-register', [SessionController::class, 'adminRegister']);

Route::post('/ticket-seller-register', [SessionController::class, 'ticketSellerRegister']);

Route::post('/login', [SessionController::class, 'login']);

Route::post('/logout', [SessionController::class, 'logout'])->middleware('auth:sanctum', 'verified');

Route::delete('/delete', [SessionController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/verified-middleware', function(){
    return response()->json([
        'message'=> 'The email account is already confirmed now you are able to see this message...',
    ], 201);
})->middleware('auth:sanctum');

Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail'])->middleware('auth:sanctum');

Route::post('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:sanctum');

Route::post('forgot-password', [NewPasswordController::class, 'forgotPassword']);

Route::post('reset-password', [NewPasswordController::class, 'reset']);

Route::middleware('auth:sanctum')->prefix('v1')->group(function(){
    Route::resource('stations', StationController::class)->middleware(['role:admin']);
    Route::resource('associations', AssociationController::class)->middleware(['role:admin']);
    Route::resource('vehicles', VehicleController::class)->middleware(['role:admin']);
    Route::resource('deployment-lines', DeploymentLineController::class)->middleware(['role:admin']);
    Route::post('/generate-ticket', TicketGeneratorController::class);
    Route::get('/daily-report', [ReportController::class, 'dailyReport']);
    Route::get('/weekly-report', [ReportController::class, 'weeklyReport']);
    Route::get('/monthly-report', [ReportController::class, 'monthlyReport']);
});





