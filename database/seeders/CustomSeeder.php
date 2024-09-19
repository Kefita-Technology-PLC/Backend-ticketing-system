<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class CustomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(User::count() == 0) {
            // Create the admin user
            $adminUser = User::factory()->create([
                'name' => 'Admin Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('admin1234'), // Ensure the password is hashed
                'phone_no' => '+251944055361',
            ]);

            // Assign Admin Role to Admin User
            $adminRole = Role::where('name', 'admin')->where('guard_name', 'api')->first();
            // echo $adminRole;
            if ($adminRole) {
                $adminUser->assignRole($adminRole);
            } else {
                Log::error('Admin role not found.');
            }

            // Create the ticket seller user
            $ticketSellerUser = User::factory()->create([
                'name' => 'Ticket Seller',
                'email' => 'ticketseller@ticket.com',
                'password' =>bcrypt('ticket1234'), // Ensure the password is hashed
                'phone_no' => '+251704512247',
            ]);

            // Assign Ticket Seller Role to Ticket Seller User
            $ticketSellerRole = Role::where('name', 'ticket seller')->where('guard_name', 'api')->first();

            if ($ticketSellerRole) {
                $ticketSellerUser->assignRole($ticketSellerRole);
            } else {
                Log::error('Ticket seller role not found.');
            }

            // Create the ticket seller user
            $superAdmin = User::factory()->create([
                'name' => 'Super Admin',
                'email' => 'superadmin@super.com',
                'password' => bcrypt('superadmin1234'), // Ensure the password is hashed
                'phone_no' => '+251983148601',
            ]);

            // Assign Ticket Seller Role to Ticket Seller User
            $superAdminRole = Role::where('name', 'super admin')->where('guard_name', 'api')->first();
            if ($superAdminRole) {
                $superAdmin->assignRole($superAdminRole);
            } else {
                Log::error('Ticket seller role not found.');
            }
        }

    }
}
