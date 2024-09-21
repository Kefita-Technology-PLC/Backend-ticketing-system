<?php

use App\Http\Controllers\GoogleAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('auth/google/redirect', [GoogleAuthController::class, 'redirectToGoogle']);
Route::get('auth/google/callback',[GoogleAuthController::class, 'handleGoogleCallback']);

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
});

