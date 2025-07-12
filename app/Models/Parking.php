<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'slot_id',
        'parked_by',
        'parked_at',
        'unparked_at',
        'status'
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function slot()
    {
        return $this->belongsTo(ParkingSlot::class, 'slot_id');
    }

    public function attendant()
    {
        return $this->belongsTo(User::class, 'parked_by');
    }

}
