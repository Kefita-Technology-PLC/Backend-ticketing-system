<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

Route::get('/', function () {
    return view('welcome');
    $role = Role::create(['name' => 'admin', 'guard_name' => 'api']);
});

Route::get('auth/google/redirect', function(){
    return Socialite::driver('google')->redirect();
});

Route::get('auth/google/callback', function(Request $request){
    //dd();

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


            Auth::login($user);
            return response()->json([
                'status'=>true,
                'message' => 'User has registered and logged in successfully',
                'token' => $user->createToken('API TOKEN')->plainTextToken,
            ]);
        }

    }catch(Exception $e){
        dd($e->getMessage());
    }
});