<?php

namespace Database\Factories;

use App\Models\Station;
use App\Models\Vehicle;
use App\Models\Tariff;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Fetch random station and vehicle
        $station = Station::inRandomOrder()->first();
        $vehicle = Vehicle::inRandomOrder()->first();

        // Define a random destination
        $destination = fake()->randomElement([
            'mexico','megenagna','cmc','goro','taffo', 'kara', 'wesen', 'urael',
            'bole', 'wollo-sefer', 'atlas', 'kazanchis','piassa', '22-mazoriya',
            'saris', 'lebu', 'kotebe'
        ]);

        // Fetch the tariff based on origin, destination, and vehicle type (car_type)
        $tariff = Tariff::where('origin', $station->name)
                        ->where('destination', $destination)
                        ->where('car_type', $vehicle->car_type)
                        ->first();

        // echo($tariff);

        // Debugging: Check if $tariff is found
        if (!$tariff) {
            echo "No tariff found for origin: {$station->name}, destination: {$destination}, car_type: {$vehicle->car_type}\n";
        } else {
            echo "Tariff found: " . json_encode($tariff) . "\n";
            echo "Vehicle level: {$vehicle->level}\n";
        }
        // Determine the base price based on the vehicle's level
        $basePrice = $tariff ? match ($vehicle->level) {
            'level_1' => $tariff->level1_price,
            'level_2' => $tariff->level2_price,
            'level_3' => $tariff->level3_price,
            default => 0
        } : 0;


        echo "Base Price: {$basePrice}\n";

        // Multiply the base price by the number of passengers
        $price = $basePrice * $vehicle->number_of_passengers;

        $createdAt = fake()->dateTimeBetween('-1 month', 'now');
        $updatedAt = fake()->dateTimeBetween($createdAt, 'now');

        return [
            'user_id' => 1,
            'vehicle_id' => $vehicle->id,
            'station_id' => $station->id,
            'origin' => $station->name,
            'destination' => $destination,
            'level' => $vehicle->level,
            'number_of_passengers'=> $vehicle->number_of_passengers,
            'price' => $price,  // Price multiplied by the number of passengers
            'service_price' => 2.00,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }
}
