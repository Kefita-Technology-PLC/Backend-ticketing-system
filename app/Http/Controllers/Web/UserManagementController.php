<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserManagementController extends Controller
{
    public function index() {
        // Fetch users with 'admin' role under the 'api' guard
        $users = User::whereHas('roles', function($query) {
            $query->where('name', 'admin')->where('guard_name', 'api');
        })->get();

        return Inertia::render("User-management/Index", [
            'users' => $users
        ]);
    }

}
