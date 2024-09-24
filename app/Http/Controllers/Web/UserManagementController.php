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

        $users = $query->orderBy($sortField, $sortDirection)->with('creator','updater')->paginate(10);

        return Inertia::render("user-managements/Index", [
            'users' => UserManagementIndexResource::collection( $users ),
            'queryParams' => request()->query() ?: null,
        ]);
    }

    public function create(){
        return Inertia::render('user-managements/Create');
    }

}
