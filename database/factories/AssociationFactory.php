<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Association>
 */
class AssociationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company,
            'establishment_date' => fake()->date(),
            'created_by' => User::role(['admin', 'super admin'])->inRandomOrder()->first()->id,
            'updated_by' => User::role(['admin', 'super admin'])->inRandomOrder()->first()->id,
        ];
    }
}
