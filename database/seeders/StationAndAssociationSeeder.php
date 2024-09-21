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

        if(Station::count() == 0 && Association::count() == 0){
            $stations = Station::factory(100)->create();

            // Create 5 associations and attach stations
            $associations = Association::factory(40)->create();
            $associations->each(function ($association) use ($stations) {
                $randomStations = $stations->random(rand(1, 5));
                $association->stations()->attach($randomStations);
            });
        }
    }
}
