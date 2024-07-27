<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DeploymentLine>
 */
class DeploymentLineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'origin' => fake()->randomElement(['megenagna', 'mexico', 'ayertena', 'kotebe', 'yekabado']),
            'destination' => fake()->randomElement(['megenagna', 'mexico', 'ayertena', 'kotebe', 'yekabado']),
        ];
    }
}
