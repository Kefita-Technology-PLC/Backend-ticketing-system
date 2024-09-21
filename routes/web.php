<?php

use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\UserManagementController;
use App\Http\Controllers\Web\VehicleController;
use App\Http\Resources\Web\UserResource;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

<<<<<<< HEAD
Route::get('auth/google/ticket-seller/redirect', [GoogleAuthController::class, 'redirectToGoogleForTicketSeller']);
Route::get('auth/google/ticket-seller/callback', [GoogleAuthController::class, 'handleGoogleCallbackForTicketSeller']);


Route::get('/dummyapi', function(Request $request){
    // $to ='0944055361';
    // $otp = '4875';
    // $domain = 'biruklemma.com';
    // $id = '24516';

    // $server = 'https://sms.yegara.com/api3/send';
    // $postData = array('to' => $to, 'otp' => $otp,  'id' =>$id,  'domain' => $domain );
    // $content = json_encode($postData);
    // $curl = curl_init($server);
    // curl_setopt($curl, CURLOPT_HEADER, false);
    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($curl, CURLOPT_HTTPHEADER,  array("Content-type: application/json"));
    // curl_setopt($curl, CURLOPT_POST, true);
    // curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
    // $json_response = curl_exec($curl);
    // $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    // curl_close($curl);

    // return $json_response;
=======
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
>>>>>>> 30c57c215afd813bd8e5accc29225f0941c8f3bb
});

Route::middleware(['auth', 'role:admin|super admin'])->group(function () {
    Route::resource('vehicles', VehicleController::class)->middleware(['']);
});

Route::middleware(['auth','role:super admin'])->group(function () {
    Route::resource('user-management', UserManagementController::class);
});




Route::get('auth/google/redirect',[GoogleAuthController::class,'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleAuthController::class,'handleGoogleCallback']);

Route::get('auth/google/ticket-seller/redirect', [GoogleAuthController::class,'redirectToGoogleForTicketSeller']);
Route::get('auth/google/ticket-seller/callback', [GoogleAuthController::class,'handleGoogleCallbackForTicketSeller']);

Route::get('/test', function(){
    // $adminRoleApi = Role::where('name', 'admin')->where('guard_name', 'api')->first();
     $adminRoleWeb = Role::where('name', 'admin')->where('guard_name', 'web')->first();

    // for($i=0; $i<5; $i++){
    //     $user = User::factory()->create();
    //     $user->assignRole($adminRoleApi);
    //     $user->assignRole($adminRoleWeb);
    // }

    return dd(Role::where('name', 'admin')->where('guard_name', 'api')->first());
});

require __DIR__.'/auth.php';
