<?php

namespace Database\Factories;

use App\Models\Association;
use App\Models\DeploymentLine;
use App\Models\Station;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'station_id'=> Station::inRandomOrder()->first()->id,
            'association_id'=> Association::inRandomOrder()->first()->id,
            'plate_number' => fake()->unique()->randomNumber(5),
            'level' => fake()->randomElement(['level_1', 'level_2', 'level_3']),
            'number_of_passengers' => fake()->randomElement([24, 12, 15, 20]),
            'deployment_line_id' => DeploymentLine::factory()->create(),
            'code' => fake()->randomElement([1,3]),
            'car_type' => fake()->randomElement(['mini_bus','bus','higer', 'lochin']),
        ];
    }
}
