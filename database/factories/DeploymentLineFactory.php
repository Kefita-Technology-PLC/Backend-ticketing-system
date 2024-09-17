<?php

namespace Database\Factories;

use App\Models\User;
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
            'created_by' => User::role(['admin', 'super admin'])->inRandomOrder()->first()->id,
            'updated_by' => User::role(['admin', 'super admin'])->inRandomOrder()->first()->id,
        ];
    }
}
