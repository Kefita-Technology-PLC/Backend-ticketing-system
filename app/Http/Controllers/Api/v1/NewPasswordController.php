<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SendPasswordResetLink;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\ValidationException;

class NewPasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);


        SendPasswordResetLink::dispatch($request->only('email')['email']);

        // if ($status == Password::RESET_LINK_SENT) {
        //     return response()->json([
        //         'status' => __($status)
        //     ]);
        // }

        // throw ValidationException::withMessages([
        //     'email' => [trans($status)],
        // ]);

        return response()->json([
            'status' => 'Reset link will be sent shortly.'
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
