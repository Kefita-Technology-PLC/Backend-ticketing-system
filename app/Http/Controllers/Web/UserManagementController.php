<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\UserEditResource;
use App\Http\Resources\Web\UserManagementIndexResource;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    public function index() {
        // Fetch users with 'admin' role under the 'api' guard

        $sortField = request('sort_field','created_at');
        $sortDirection = request('sort_direction', 'desc');

        $query = User::whereHas('roles', function($query) {
            $query->where('name', 'admin')->where('guard_name', 'api');
        });

        if(request('name')) {
            $query->where('name','like','%'. request('name') .'%');
        }

        $sortField = request('sort_field', 'created_at');
        $sortDirection = request('sort_direction', 'desc');

        $users = $query->orderBy($sortField, $sortDirection)->with('creator','updater','station')->paginate(10);

        return Inertia::render("user-managements/Index", [
            'users' => UserManagementIndexResource::collection( $users ),
            'queryParams' => request()->query() ?: null,
        ]);
    }

    public function create(){
        return Inertia::render('user-managements/Create');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone_no' => ['required', 'regex:/^\+251[79]\d{8}$/', 'unique:users,phone_no'],
            'gender' => 'required|in:male,female,other',
            'salary' => 'required|string|min:3',
            'station_id' => 'required|exists:stations,id',
            'permissions' => 'array',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone_no' => $validated['phone_no'],
            'gender' => $validated['gender'],
            'salary' => $validated['salary'],
            'station_id' => $validated['station_id'],
            'created_by' => Auth::user()->id,
        ]);

        $adminRoleApi = Role::where('name', 'admin')->where('guard_name', 'api')->first();
        $adminRoleWeb = Role::where('name', 'admin')->where('guard_name', 'web')->first();

        $user->assignRole($adminRoleApi); 
        $user->assignRole($adminRoleWeb); 
        

        if(!empty($validated['permissions'])){
            $user->syncPermissions($validated['permissions']);
        }

        return to_route('user-managements.index')->with('success','A user created successfully');
    }

    public function edit(string $id){
        $user = User::findOrFail(intval($id));
        // dd($user);

        // dd(new UserManagementIndexResource($user));
        return Inertia::render('user-managements/Edit',[
            'user'=>new UserEditResource($user) ,
        ]);
    }

    public function update(Request $request, string $id) {
        $user = User::findOrFail(intval($id));
    
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            // Validate password and confirmation only if password is provided
            'password' => 'nullable|string|min:8|confirmed',
            'phone_no' => ['required', 'regex:/^\+251[79]\d{8}$/', 'unique:users,phone_no,' . $user->id],
            'gender' => 'required|in:male,female,other',
            'salary' => 'required|string|min:3',
            'station_id' => 'required|exists:stations,id',
            'permissions' => 'array',
        ]);
    
        // Update the user with the validated data
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_no' => $validated['phone_no'],
            'gender' => $validated['gender'],
            'salary' => $validated['salary'],
            'station_id' => $validated['station_id'],
            'updated_by' => Auth::user()->id,
        ]);
    
        // Update the password if it is provided
        if (isset($validated['password']) && !empty($validated['password'])) {
            $user->password = bcrypt($validated['password']); // Hash the password before saving
        }
    
        // Save the user after updating the password if needed
        $user->save();
    
        // Update the user's permissions
        if (isset($validated['permissions'])) {
            // Sync the permissions using a relationship method
            $user->syncPermissions($validated['permissions']);
        }
    
        // Return a response, e.g., redirect or return success message
        return to_route('user-managements.index')->with('success','User has updated successfullu.');
    }

    public function destroy(string $id){
        $user = User::findOrFail(intval($id));
        $name = $user->name;
        $user->delete();

        return to_route('user-managements.index')->with('success', $name.' '.'has been deleted sucessfully.');
    }
    

}
