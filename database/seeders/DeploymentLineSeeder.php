<?php

namespace Database\Seeders;

use App\Models\DeploymentLine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeploymentLineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(DeploymentLine::count() == 0){
            DeploymentLine::factory(10)->create();
        }
    }
}
