<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NumberOfPassengersSeeder extends Seeder
{
    /**
     * Array of possible passenger numbers for cars in Ethiopia.
     */
    public $array = [
        ['number' => 4],
        ['number' => 7],
        ['number' => 12],
        ['number' => 15],
        ['number' => 24],
        ['number' => 35],
        ['number' => 45],
        ['number' => 60],
        ['number' => 70],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert the passenger numbers into the database
        DB::table('number_of_passengers')->insert($this->array);
    }
}
