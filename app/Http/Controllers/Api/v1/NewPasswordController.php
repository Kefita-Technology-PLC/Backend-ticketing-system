<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SendPasswordResetLink;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;


class NewPasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid email address.',
                'errors' => $validator->errors()
            ], 422);
        }
    
        // Check if the email exists in the database
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email not found in our records.',
                'errors' => [
                    'email' => 'Email not found in our records.'
                ]
            ], 404);
        }
    
        // Send the password reset link
        Password::sendResetLink(
            $request->only('email')
        );
    
        return response()->json([
            'status' => 'success',
            'message' => 'You will receive a password reset link shortly.'
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'phone_no' => 'required',
            'password' => ['required', 'confirmed',],
        ]);

        $status = Password::reset(
            $request->only('phone_no', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                $user->tokens()->delete();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response()->json([
                'message'=> 'Password reset successfully'
            ]);
        }

        return response()->json([
            'message'=> __($status)
        ], 500);

    }
}
