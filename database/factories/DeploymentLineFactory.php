<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Role;

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
        $adminRoleWeb = Role::where('name', 'admin')->where('guard_name', 'web')->first();
        $adminRoleApi = Role::where('name', 'admin')->where('guard_name', 'api')->first();
        $superAdminRoleWeb = Role::where('name', 'super admin')->where('guard_name', 'web')->first();
        $superAdminRoleApi = Role::where('name', 'super admin')->where('guard_name', 'api')->first();

        $usersWithRoles = User::whereHas('roles', function ($query) use ($adminRoleWeb, $adminRoleApi, $superAdminRoleWeb, $superAdminRoleApi) {
            $query->whereIn('role_id', [$adminRoleWeb->id, $superAdminRoleWeb->id])
                  ->orWhereIn('role_id', [$adminRoleApi->id, $superAdminRoleApi->id]);
        })->inRandomOrder()->get();

        return [
            'origin' => fake()->randomElement(['megenagna', 'mexico', 'ayertena', 'kotebe', 'yekabado']),
            'destination' => fake()->randomElement(['megenagna', 'mexico', 'ayertena', 'kotebe', 'yekabado']),
            'created_by' => $usersWithRoles->isNotEmpty() ? $usersWithRoles->first()->id : null,
            'updated_by' => $usersWithRoles->isNotEmpty() ? $usersWithRoles->random()->id : null,
        ];
    }
}
