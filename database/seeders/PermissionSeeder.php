<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(Permission::count() == 0){
            $permissions = [
                ['name'=> 'add vehicles'],
                ['name'=> 'update vehicles'],
                ['name'=> 'delete vehicles'],
                
                ['name'=> 'add stations'],
                ['name'=> 'update stations'],
                ['name'=> 'delete stations'],
    
                ['name'=> 'add associations'],
                ['name'=> 'update associations'],
                ['name'=> 'delete associations'],

                ['name'=> 'add tariffs'],
                ['name'=> 'update tariffs'],
                ['name'=> 'delete tariffs'],
            ];
    
            foreach ($permissions as $permission) {
                Permission::create([
                    'name'=> $permission['name'],
                    'guard_name' => 'api'
                ]);
                Permission::create([
                    'name'=> $permission['name'],
                    'guard_name' => 'web'
                ]);
            }
            
        }
    }
}
