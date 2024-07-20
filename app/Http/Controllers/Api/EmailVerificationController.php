<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{

    public function sendVerificationEmail(Request $request)
    {
        if($request->user()->hasVerifiedEmail()){
            return response()->json([
                'status' => true,
                'message' => 'Already Verified',
            ]);
        }
        $request->user()->sendEmailVerificationNotification();
        
        return response()->json([
            'status' => true,
            'message' => 'Verification Link Sent',
        ]);
    }


    public function verify(Request $request){
        if ($request->user()->hasVerifiedEmail()) {
            return [
                'message' => 'Email already verified'
            ];
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return [
            'message'=>'Email has been verified'
        ];

    }

}
