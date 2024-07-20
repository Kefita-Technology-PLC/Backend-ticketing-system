<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SessionController extends Controller
{
    public function register(Request $request)
    {
        $attrs = Validator::make($request->all(),[
            'name'=> 'required',
            'email'=> 'required|email|unique:users,email',
            'password'=> 'required',
        ]);

        if($attrs->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $attrs->errors()
            ], 401);
        }

        $user = User::create([
            'name'=> $request->name,
            'email' => $request->email,
            'password'=> $request->password,
        ]);

        event(new Registered($user));
        $user->sendEmailVerificationNotification();
        return response()->json([
            'status' => true,
            'message' => 'User Created Successfully. Email Verification link sent',
            'token' => $user->createToken("API TOKEN")->plainTextToken,
            'data'=>[
                'user'=> $user,
            ]
        ]);
    }

    public function login(Request $request)
    {
        try{
            $attrs = Validator::make($request->all(), [
                'email'=> 'required|email',
                'password'=> 'required',
            ]);
    
            if($attrs->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error',
                    'errors' => $attrs->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'The credintials do not match',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();
            return response()->json([
                'status'=> true,
                'message'=> 'User login successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken,
            ]);

        }catch(\Throwable $th){
            return response()->json([
                'status'=> false,
                'message'=> $th->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(
            [
                'message' => 'Logged out'
            ]
        );
    }

    public function profile(){
        $user = auth()->user();
        return response()->json([
            'status'=> true,
            'message'=> 'Profile Information',
            'data'=> $user,
            'id'=> auth()->user()->id
        ]);
    }
}
