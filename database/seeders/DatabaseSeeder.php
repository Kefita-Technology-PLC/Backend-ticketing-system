<?php

namespace Database\Seeders;

use App\Models\Association;
use App\Models\Station;
use App\Models\Tariff;
use App\Models\Vehicle;
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
        $this->callOnce(NumberOfPassengersSeeder::class);

        $this->callOnce(CustomSeeder::class);

        $this->callOnce(StationAndAssociationSeeder::class);
        // Seed Vehicles and Tariffs
        $this->callOnce(VehicleSeeder::class);
        $this->callOnce(TariffSeeder::class);
    }
}
