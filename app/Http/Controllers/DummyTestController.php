<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DummyTestController extends Controller
{
    public function __invoke()
    {
        $role = Role::create(['name' => 'ticket seller', 'guard_name' => 'api']);

        $permission = Permission::create(['name'=>'add ticket record', 'guard_name'=>'api']);  
        $permission2 = Permission::create(['name'=>'update ticket record', 'guard_name'=>'api']); 
        $permission3 = Permission::create(['name'=>'delete ticket record', 'guard_name'=>'api']); 
    
        $role = Role::create(['name'=>'ticket seller','guard_name'=>'api']); 
        $role->givePermissionTo($permission);  
        $role->givePermissionTo($permission2); 
        $role->givePermissionTo($permission3); 
    }
}
