<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\ParkingSlot;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParkingTest extends TestCase
{
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_vehicle_can_be_parked()
    {
        $attendant = User::factory()->create(['role' => 'attendant']);
        $slot = ParkingSlot::factory()->create(['available_slots' => 5]);

        $response = $this->actingAs($attendant)->postJson('/api/park', [
            'vehicle_number' => 'KA01AB1234',
            'vehicle_type' => 'car',
            'owner_name' => 'Ravi',
            'slot_id' => $slot->id,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('parkings', ['status' => 'parked']);
    }

}
