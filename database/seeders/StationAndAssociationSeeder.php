<?php

namespace Database\Seeders;

use App\Models\Association;
use App\Models\Station;
use Illuminate\Database\Seeder;

class StationAndAssociationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 stations
        $stations = Station::factory(10)->create();

        // Create 5 associations and attach stations
        $associations = Association::factory(5)->create();
        $associations->each(function ($association) use ($stations) {
            $randomStations = $stations->random(rand(1, 5));
            $association->stations()->attach($randomStations);
        });
    }
}
