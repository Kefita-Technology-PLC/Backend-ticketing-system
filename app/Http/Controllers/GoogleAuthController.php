<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request){
        try{
            $googleUser  = Socialite::driver("google")->stateless()->user();
            $user = User::where('google_id', $googleUser->id)->first();
    
            if($user){
                Auth::login($user);
                return response()->json([
                    'status' => true,
                    'message' => 'User logged in successfully',
                    'token' => $user->createToken('API TOKEN')->plainTextToken,
                ]);
            } else{
                $user = User::updateOrCreate([
                    'google_id' => $googleUser->id
                ],[
                    'name'=> $googleUser->name,
                    'email'=> $googleUser->email,
                    'email_verified_at'=> now(),
                ]);
    
                //Assign admin role
                $user->assignRole('admin');
                Auth::login($user);
                return response()->json([
                    'status'=>true,
                    'message' => 'User has registered and logged in successfully',
                    'token' => $user->createToken('API TOKEN')->plainTextToken,
                ]);
            }
    
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Authentication failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function redirectToGoogleForTicketSeller(){
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallbackForTicketSeller(Request $request){
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
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
                $user->assignRole('ticket seller');
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
