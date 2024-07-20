<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;
use Laravel\Socialite\Two\GoogleProvider;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle(){
        return Socialite::buildProvider(
            GoogleProvider::class,
            config('services.google_admin')
        )->redirect();

    }

    public function handleGoogleCallback(){
        try{
            $googleUser = Socialite::buildProvider(
                GoogleProvider::class,
                config('services.google_admin')
            )->stateless()->user();

            $user = User::where('google_id', $googleUser->id)->first();
    
            if($user){
                Auth::login($user);
                return response()->json([
                    'status' => true,
                    'message' => 'Admin logged in successfully',
                    'token' => $user->createToken('API TOKEN')->plainTextToken,
                ]);
            } 
                $user = User::updateOrCreate([
                    'google_id' => $googleUser->id
                ],[
                    'name'=> $googleUser->name,
                    'email'=> $googleUser->email,
                    'email_verified_at'=> now(),
                ]);
    
                //Assign admin role
                $adminRole = Role::where('name', 'admin')->where('guard_name', 'api')->first();
                $user->assignRole($adminRole);

                Auth::login($user);
                return response()->json([
                    'status'=>true,
                    'message' => 'User has registered and logged in successfully',
                    'token' => $user->createToken('API TOKEN')->plainTextToken,
                ]);
            
    
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Authentication failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function redirectToGoogleForTicketSeller(){
        return Socialite::buildProvider(
            GoogleProvider::class,
            config('services.google_ticket_seller')
        )->redirect();
    }

    public function handleGoogleCallbackForTicketSeller(){
        try {
            $googleUser = Socialite::buildProvider(
                GoogleProvider::class,
                config('services.google_ticket_seller')
            )->stateless()->user();

            $user = User::where('google_id', $googleUser->id)->first();

            if ($user) {
                Auth::login($user);
            } else {
                $user = User::updateOrCreate([
                    'google_id' => $googleUser->id,
                ], [
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'email_verified_at' => now(),
                ]);

                // Assign role for ticket sellers
                $ticketSeller = Role::where('name', 'ticket seller')->where('guard_name', 'api')->first();
                $user->assignRole($ticketSeller);

                Auth::login($user);
            }

            return response()->json([
                'status' => true,
                'message' => 'Ticket seller logged in successfully',
                'token' => $user->createToken('API TOKEN')->plainTextToken,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Authentication failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
