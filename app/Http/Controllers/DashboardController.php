<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\ParkingSlot;
use App\Models\Parking;

class DashboardController extends Controller
{
    public function index()
    {
        $totalVehicles = Vehicle::count();
        $currentlyParked = Parking::where('status', 'parked')->count();
        $locations = ParkingSlot::select('location_name', 'total_slots', 'available_slots')->get();

        return view('dashboard', compact('totalVehicles', 'currentlyParked', 'locations'));
    }
}
