<?php

namespace Database\Factories;

use App\Models\Association;
use App\Models\DeploymentLine;
use App\Models\Station;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Role;

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
        $adminRoleWeb = Role::where('name', 'admin')->where('guard_name', 'web')->first();
        $adminRoleApi = Role::where('name', 'admin')->where('guard_name', 'api')->first();
        $superAdminRoleWeb = Role::where('name', 'super admin')->where('guard_name', 'web')->first();
        $superAdminRoleApi = Role::where('name', 'super admin')->where('guard_name', 'api')->first();

        $usersWithRoles = User::whereHas('roles', function ($query) use ($adminRoleWeb, $adminRoleApi, $superAdminRoleWeb, $superAdminRoleApi) {
            $query->whereIn('role_id', [$adminRoleWeb->id, $superAdminRoleWeb->id])
                  ->orWhereIn('role_id', [$adminRoleApi->id, $superAdminRoleApi->id]);
        })->inRandomOrder()->get();

        return [
            'station_id'=> Station::inRandomOrder()->first()->id,
            'association_id'=> Association::inRandomOrder()->first()->id,
            'plate_number' => fake()->unique()->randomNumber(5),
            'level' => fake()->randomElement(['level_1', 'level_2', 'level_3', 'level_4']),
            'number_of_passengers' => fake()->randomElement([24, 12, 15, 20]),
            'deployment_line_id' => DeploymentLine::inRandomOrder()->first()->id,
            'code' => fake()->randomElement([1,3]),
            'car_type' => fake()->randomElement(['mini_bus','bus','higer', 'lonchin','taxi']),
            'region' => fake()->randomElement(['TG','AF','AA','SN','DR','SD','AM','OR','SM','BN','HR','SW','ET']),
            'created_by' => $usersWithRoles->isNotEmpty() ? $usersWithRoles->first()->id : null,
            'updated_by' => $usersWithRoles->isNotEmpty() ? $usersWithRoles->random()->id : null,
        ];
    }
}
