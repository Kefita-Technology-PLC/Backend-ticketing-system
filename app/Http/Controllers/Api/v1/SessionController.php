<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Jobs\EmailVerificationSend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;

class SessionController extends Controller
{
    public function adminRegister(Request $request)
    {
        $attrs = Validator::make($request->all(),[
            'name'=> 'required|string',
            'email'=> 'required|email|unique:users,email',
           'phone_no' => ['required', 'regex:/^\+251[97]\d{8}$/', 'unique:users,phone_no'],
            'password'=> ['required',RulesPassword::min(4), 'confirmed'],
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
            'phone_no' => $request->phone_no,
            'password'=> $request->password,
        ]);

        EmailVerificationSend::dispatch($user);
        $adminRoleApi = Role::where('name', 'admin')->where('guard_name', 'api')->first();
        $adminRoleWeb = Role::where('name', 'admin')->where('guard_name', 'web')->first();

        $user->assignRole($adminRoleApi);// assigning admin role for the api
        $user->assignRole($adminRoleWeb); // assigning admin role for the web
        
        return response()->json([
            'status' => true,
            'message' => 'Admin User Created Successfully. Email Verification link sent',
            'token' => $user->createToken("API TOKEN")->plainTextToken,
            'data'=>[
                'user'=> $user,
            ]
        ]);
    }

    public function ticketSellerRegister(Request $request)
    {
        $attrs = Validator::make($request->all(),[
            'name'=> 'required',
            'phone_no' => ['required', 'regex:/^\+251[97]\d{8}$/', 'unique:users,phone_no'],
            'password'=> ['required', RulesPassword::min(4)],
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
            'phone_no' => $request->phone_no,
            'password'=> $request->password,
        ]);

        EmailVerificationSend::dispatch($user);
        $ticketSeller = Role::where('name', 'ticket seller')->where('guard_name', 'api')->first();

        $user->assignRole($ticketSeller);

        return response()->json([
            'status' => true,
            'message' => 'Ticket Seller User Created Successfully. Email Verification link sent',
            'token' => $user->createToken("API TOKEN")->plainTextToken,
            'data'=>[
                'user'=> $user,
            ]
        ]);
    }

    public function login(Request $request)
    {
        try {
            $attrs = Validator::make($request->all(), [
                'phone_no' => ['required', 'regex:/^\+251[97]\d{8}$/'],
                'password' => ['required', RulesPassword::min(6)],
            ]);

            if ($attrs->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error',
                    'errors' => $attrs->errors()
                ], 401);
            }

            // Log request input
            Log::info('Phone No: ' . $request->phone_no);
            Log::info('Password: ' . $request->password);

            $user = User::where('phone_no', $request->phone_no)->first();

            // Log database password
            Log::info('Database Password: ' . $user->password);

            // dd($user);

            if (!$user || !Auth::attempt(['phone_no' => $request->phone_no, 'password' => $request->password])) {
                return response()->json([
                    'status' => false,
                    'message' => 'The credentials do not match',
                    'errors' => [
                        'message' => 'The credentials do not match'
                    ]
                ], 401);
            }

            return response()->json([
                'status' => true,
                'message' => 'User login successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken,
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }



    public function update(Request $request)
    {
        $attrs = Validator::make($request->all(),[
            'name'=> 'required',
            'email'=> 'required|email|unique:users,email',
            'phone_no' => ['required', 'regex:/^(09|07)[0-9]{8}$/'],
            'password'=> ['required', RulesPassword::min(4)],
        ]);

        if($attrs->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $attrs->errors()
            ], 401);
        }

        $request->user()->update([
            'name'=> $request->name,
            'email' => $request->email,
            'phone_no' => $request->phone_no,
            'password'=> $request->password,
        ]);

        EmailVerificationSend::dispatch($request->user());

        return response()->json([
            'status' => true,
            'message' => 'User Credintials Updated Successfully',
            'token' => $request->user()->createToken("API TOKEN")->plainTextToken,
            'data'=>[
                'user'=> $request->user(),
            ]
        ]);
    }

    public function logout(Request $request)
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

    public function destroy(Request $request){
        $request->user()->delete();
        return response()->json([
            'status' => true,
            'message' => 'User Deleted Successfully'
        ]);
    }
}
