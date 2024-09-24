<?php

use App\Http\Controllers\Api\v1\SessionController;
use App\Http\Controllers\Api\v1\EmailVerificationController;
use App\Http\Controllers\Api\v1\NewPasswordController;
use App\Http\Controllers\Api\v1\StationController;
use App\Http\Controllers\Api\v1\AssociationController;
use App\Http\Controllers\Api\v1\DeploymentLineController;
use App\Http\Controllers\Api\V1\NumberOfPassengersController;
use App\Http\Controllers\Api\v1\ReportController;
use App\Http\Controllers\Api\v1\TariffController;
use App\Http\Controllers\Api\v1\TicketGeneratorController;
use App\Http\Controllers\Api\v1\VehicleController;
use App\Http\Controllers\ForSelectionForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/admin-register', [SessionController::class, 'adminRegister']);

Route::post('/ticket-seller-register', [SessionController::class, 'ticketSellerRegister']);

Route::post('/login', [SessionController::class, 'login']);

Route::post('/logout', [SessionController::class, 'logout'])->middleware('auth:sanctum');

Route::delete('/user-delete', [SessionController::class, 'destroy'])->middleware('auth:sanctum');

Route::patch('/user-update', [SessionController::class, 'update'])->middleware('auth:sanctum');

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
    Route::resource('stations', StationController::class)->middleware(['role:admin|super admin']);

    Route::resource('associations', AssociationController::class)->middleware(['role:admin|super admin']);

    Route::resource('vehicles', VehicleController::class)->middleware(['role:admin|super admin']);

    Route::get('/vehicles-search',[VehicleController::class,'searchQueries']);

    Route::resource('deployment-lines', DeploymentLineController::class)->middleware(['role:admin|super admin']);

    Route::get('/deployment-lines', [DeploymentLineController::class,'searchQueries']);

    Route::resource('tariffs', TariffController::class)->middleware(['role:admin|super admin']);

    Route::resource('passengers', NumberOfPassengersController::class)->middleware(['role:admin|super admin']);

    Route::post('/generate-ticket', [TicketGeneratorController::class, 'ticketWebsite']);

    Route::get('/daily-report', [ReportController::class, 'dailyReport'])->middleware(['role:admin|super admin']);

    Route::get('/general-report', [ReportController::class, 'generalReport'])->middleware(['role:admin|super admin']);

    Route::get('/monthly-report', [ReportController::class, 'monthlyReport'])->middleware(['role:admin|super admin']);

    Route::get('/weekly-report', [ReportController::class, 'weeklyReport'])->middleware(['role:admin|super admin']);

    Route::get('/yearly-report', [ReportController::class, 'yearlyReport'])->middleware(['role:admin|super admin']);

    Route::get('/custom-report', [ReportController::class, 'customDateReport'])->middleware(['role:admin|super admin']);

    Route::get('/stations-all', [StationController::class, 'getAll']);
    Route::get('/vehicles-all', [VehicleController::class, 'getAll']);
    Route::get('/associations-all', [AssociationController::class, 'getAll']);
    Route::get('/deployment-lines-all', [DeploymentLineController::class, 'getAll']);

    Route::post('/daily-report-pos', [TicketGeneratorController::class,'ticketPos']);
    // Route::post('/daily-ticket-report', ReportControol)
});

Route::prefix('v1')->group(function(){
    Route::get('/car-types', [ForSelectionForm::class, 'carType']);
    Route::get('/get-stations', [ForSelectionForm::class, 'stationNames']);
    Route::get('/get-associations', [ForSelectionForm::class, 'associationNames']);
    Route::get('/stations-search', [StationController::class,'searchQueries']);
});

Route::prefix('v1')->group(
    function(){
        Route::get('/stations-search', [StationController::class,'searchQueries']);
        Route::get('/associations-search',[AssociationController::class,'searchQueries']);
    }
);





