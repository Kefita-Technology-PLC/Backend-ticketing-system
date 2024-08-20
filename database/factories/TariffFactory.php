<?php

namespace Database\Factories;

use App\Models\Destination;
use App\Models\Station;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'station_id' => Station::factory()->create(),
            // 'destination_id' => Destination::factory()->create(),
            'distance'=> fake()->randomElement(['4kms', '1.5kms','2kms', '10kms', '7kms']),
            'destination' => fake()->randomElement(['mexico','megenagna','cmc','goro','taffo', 'kara', 'wesen', 'urael', 'bole', 'wollo-sefer', 'atlas', '22-mazoriya', 'saris', 'lebu', 'kotebe']),
            'origin' => fake()->randomElement(['mexico','megenagna','cmc','goro','taffo', 'kara', 'wesen', 'urael', 'bole', 'wollo-sefer', 'atlas', '22-mazoriya', 'saris', 'lebu', 'kotebe']),
            'car_type' => fake()->randomNumber(['lochin', 'mini-bus', 'automotive']),
            // 'number_of_passengers' => fake()->randomElement(['12', '24', '20', '10', '5', '8', '9']),
            'level1_price' => fake()->randomNumber(3),
            'level2_price' => fake()->randomNumber(3),
            'level3_price' => fake()->randomNumber(3),
            // 'total_triff' => fake()->randomNumber(4)
        ];
    }
}
