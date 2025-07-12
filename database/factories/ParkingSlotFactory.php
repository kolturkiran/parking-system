<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ParkingSlot>
 */
class ParkingSlotFactory extends Factory
{
    public function definition()
    {
        $total = fake()->numberBetween(10, 20);
        return [
            'location_name' => fake()->city,
            'total_slots' => $total,
            'available_slots' => $total,
        ];
    }
}
