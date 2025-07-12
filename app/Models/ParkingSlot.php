<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_name',
        'total_slots',
        'available_slots'
    ];

    public function parkings()
    {
        return $this->hasMany(Parking::class, 'slot_id');
    }
}
