<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Station>
 */
class StationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            
            'name' => fake()->randomElement([
                'megenagna-station', 'mexico-station', 'tuludimtu-station', 'goro-station', 'ayertena-station', 'yekabado-station', 'koyefiche-station', 'addisugebeya-station','merkato-station', 'torhayloch-station', 'piassa-station', '4kilo-station', 'bole-station'
            ]),

            'location' => fake()->randomElement([
                'megenagna', 'mexico', 'tuludimtu', 'goro', 'ayertena', 'yekabado', 'koyefiche', 'addisugebeya','merkato', 'torhayloch', 'piassa', '4kilo', 'bole'
            ]),
        ];
    }
}
