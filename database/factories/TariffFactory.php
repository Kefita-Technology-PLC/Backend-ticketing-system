<?php

namespace Database\Factories;

use App\Models\Station;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tariff>
 */
class TariffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Fetch a random station
        $station = Station::inRandomOrder()->first();

        return [
            'station_id' => $station->id,
            'distance'=> fake()->randomElement(['4kms', '1.5kms','2kms', '10kms', '7kms']),
            'destination' => fake()->randomElement([
                'mexico','megenagna','cmc','goro','taffo', 'kara', 'wesen', 'urael',
                'bole', 'wollo-sefer', 'atlas', 'kazanchis','piassa', '22-mazoriya',
                'saris', 'lebu', 'kotebe'
            ]),

            // Use the station's name as the origin
            'origin' => $station->name,  // Assuming the station model has a 'name' field

            'car_type' => fake()->randomElement(['lonchin', 'mini_bus', 'bus', 'taxi', 'higer']),
            'level1_price' => fake()->randomNumber(2),
            'level2_price' => fake()->randomNumber(2),
            'level3_price' => fake()->randomNumber(2),
            'created_by' => 1,
            'updated_by'=> 1,
        ];
    }
}
