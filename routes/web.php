<?php

use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\DashboardController;
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

Route::middleware(['auth', 'role:admin|super admin'])->group(function () {
    Route::resource('vehicles', VehicleController::class);
});

Route::middleware(['auth','role:super admin'])->group(function () {
    Route::resource('user-management', UserManagementController::class);
});




Route::get('auth/google/redirect',[GoogleAuthController::class,'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleAuthController::class,'handleGoogleCallback']);

Route::get('auth/google/ticket-seller/redirect', [GoogleAuthController::class,'redirectToGoogleForTicketSeller']);
Route::get('auth/google/ticket-seller/callback', [GoogleAuthController::class,'handleGoogleCallbackForTicketSeller']);

// Route::get('/test', function(){
//     // $adminRoleApi = Role::where('name', 'admin')->where('guard_name', 'api')->first();
//      $adminRoleWeb = Role::where('name', 'admin')->where('guard_name', 'web')->first();

//     // for($i=0; $i<5; $i++){
//     //     $user = User::factory()->create();
//     //     $user->assignRole($adminRoleApi);
//     //     $user->assignRole($adminRoleWeb);
//     // }

//     return dd(Role::where('name', 'admin')->where('guard_name', 'api')->first());
// });

require __DIR__.'/auth.php';
