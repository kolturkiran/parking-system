<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    public function definition()
    {
        return [
            'vehicle_number' => strtoupper(fake()->bothify('KA##??####')),
            'vehicle_type' => fake()->randomElement(['car', 'bike', 'truck']),
            'owner_name' => fake()->name,
        ];
    }
}
