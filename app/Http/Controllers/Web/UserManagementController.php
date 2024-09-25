<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\UserManagementIndexResource;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserManagementController extends Controller
{
    public function index() {
        // Fetch users with 'admin' role under the 'api' guard

        $query = User::whereHas('roles', function($query) {
            $query->where('name', 'admin')->where('guard_name', 'api');
        });

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
        $attrs = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'phone_no' => ['required', 'regex:/^\+251[79]\d{8}$/', 'unique:users,phone_no'],
            'gender' => ['required', 'in:male,female,other'],
            'salary' => ['required'],
            'station_id' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    }

}
