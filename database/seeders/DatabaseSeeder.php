<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Roles
        $this->callOnce(RoleSeeder::class);
        $this->callOnce(PermissionSeeder::class);

        $this->callOnce(NumberOfPassengersSeeder::class);

        $this->callOnce(CustomSeeder::class);
        $this->callOnce(DeploymentLineSeeder::class);
        
        $this->callOnce(StationAndAssociationSeeder::class);
        // Seed Vehicles and Tariffs
        $this->callOnce(VehicleSeeder::class);
        $this->callOnce(TariffSeeder::class);

        $this->callOnce(TicketSeeder::class);
        $this->callOnce(TariffSeeder::class);
    }
}
