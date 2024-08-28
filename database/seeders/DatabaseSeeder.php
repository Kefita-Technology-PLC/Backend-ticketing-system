<?php

namespace Database\Seeders;

use App\Models\Association;
use App\Models\Role;
use App\Models\Station;
use App\Models\Tariff;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Roles
        $this->call(RoleSeeder::class);
        $this->call(NumberOfPassengersSeeder::class);

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

        // Create 10 stations
        $stations = Station::factory(10)->create();

        // Create 5 associations and attach stations
        $associations = Association::factory(5)->create();
        $associations->each(function ($association) use ($stations) {
            $randomStations = $stations->random(rand(1, 5));
            $association->stations()->attach($randomStations);
        });

        // Seed Vehicles and Tariffs
        Vehicle::factory(20)->create();
        Tariff::factory(10)->create();
    }
}
