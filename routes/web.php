<?php

use App\Http\Controllers\GoogleAuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

Route::get('/', function () {
    return view('welcome');
});

Route::get('auth/google/redirect', [GoogleAuthController::class, 'redirectToGoogle']);
Route::get('auth/google/callback',[GoogleAuthController::class, 'handleGoogleCallback']);

Route::get('auth/google/ticket-seller/redirect', [GoogleAuthController::class, 'redirectToGoogleForTicketSeller']);
Route::get('auth/google/ticket-seller/callback', [GoogleAuthController::class, 'handleGoogleCallbackForTicketSeller']);