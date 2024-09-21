<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(DB::table('roles')->count() == 0){
            $names = ['admin', 'super admin', 'ticket seller'];
            foreach($names as $name){
                Role::factory()->create([
                    'name' => $name,
                    'guard_name' => 'api',
                ]);
                Role::factory()->create([
                    'name' => $name,
                    'guard_name' => 'web',
                ]);
            }
        }
    }
}
