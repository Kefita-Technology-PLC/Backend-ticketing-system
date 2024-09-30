<?php

use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleInStationController;
use App\Http\Controllers\Web\AllAssociationController;
use App\Http\Controllers\Web\AllStationController;
use App\Http\Controllers\Web\AssociationInStationController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ReportController;
use App\Http\Controllers\Web\StationAndAssociationFetch;
use App\Http\Controllers\Web\UserManagementController;
use App\Http\Controllers\Web\VehicleController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('auth/google/redirect',[GoogleAuthController::class,'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleAuthController::class,'handleGoogleCallback']);

Route::get('auth/google/ticket-seller/redirect', [GoogleAuthController::class,'redirectToGoogleForTicketSeller']);
Route::get('auth/google/ticket-seller/callback', [GoogleAuthController::class,'handleGoogleCallbackForTicketSeller']);


Route::middleware('auth')->prefix('v1')->group(function () {
    Route::get('stations/{station}', [StationAndAssociationFetch::class, 'station']);

    Route::get('associations/{association}', [StationAndAssociationFetch::class, 'association']);
});

Route::middleware(['auth','role:super admin'])->group(function(){
    Route::resource('all-stations', AllStationController::class);
    Route::resource('all-associations', AllAssociationController::class);
    Route::resource('user-managements', UserManagementController::class);
    Route::resource('vehicles', VehicleController::class);
    Route::resource('reports', ReportController::class);
    Route::get('/export/csv', [ReportController::class, 'exportScv']);
    Route::get('/export/excel', [ReportController::class, 'exportExcel']);

});

Route::middleware(['auth','role:admin|super admin'])->group(function () {
    Route::resource('vehicles-stations', VehicleInStationController::class);
    Route::resource('associations-stations', AssociationInStationController::class);
});



require __DIR__.'/auth.php';
