<?php


namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

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
        $adminRoleWeb = Role::where('name', 'admin')->where('guard_name', 'web')->first();
        $adminRoleApi = Role::where('name', 'admin')->where('guard_name', 'api')->first();
        $superAdminRoleWeb = Role::where('name', 'super admin')->where('guard_name', 'web')->first();
        $superAdminRoleApi = Role::where('name', 'super admin')->where('guard_name', 'api')->first();

        $usersWithRoles = User::whereHas('roles', function ($query) use ($adminRoleWeb, $adminRoleApi, $superAdminRoleWeb, $superAdminRoleApi) {
            $query->whereIn('role_id', [$adminRoleWeb->id, $superAdminRoleWeb->id])
                  ->orWhereIn('role_id', [$adminRoleApi->id, $superAdminRoleApi->id]);
        })->inRandomOrder()->get();

        $names = [
            'megenagna-station', 'mexico-station', 'tuludimtu-station', 'goro-station', 'ayertena-station', 'yekabado-station', 'koyefiche-station', 'addisugebeya-station', 'merkato-station', 'torhayloch-station', 'piassa-station', '4kilo-station', 'bole-station'
        ];

        // Ensure the name is unique
        $name = fake()->unique()->randomElement($names);

        return [
            'name' => $name,
            'location' => fake()->randomElement([
                'megenagna', 'mexico', 'tuludimtu', 'goro', 'ayertena', 'yekabado', 'koyefiche', 'addisugebeya', 'merkato', 'torhayloch', 'piassa', '4kilo', 'bole'
            ]),
            'created_by' => $usersWithRoles->isNotEmpty() ? $usersWithRoles->first()->id : null,
            'updated_by' => $usersWithRoles->isNotEmpty() ? $usersWithRoles->random()->id : null,
        ];
    }
}
