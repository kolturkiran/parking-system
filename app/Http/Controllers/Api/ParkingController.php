<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Parking;
use App\Models\Vehicle;
use App\Models\ParkingSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Auth;

class ParkingController extends Controller
{
     /**
     * Park a vehicle
     */
    public function park(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vehicle_number' => 'required|string',
            'vehicle_type'   => 'required|in:car,bike,truck',
            'owner_name'     => 'required|string',
            'slot_id'        => 'required|exists:parking_slots,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $slot = ParkingSlot::find($request->slot_id);

        if ($slot->available_slots <= 0) {
            return response()->json(['message' => 'No available slots in this location'], 400);
        }

        $vehicle = Vehicle::firstOrCreate(
            ['vehicle_number' => strtoupper($request->vehicle_number)],
            [
                'vehicle_type' => $request->vehicle_type,
                'owner_name' => $request->owner_name
            ]
        );

        $parking = Parking::create([
            'vehicle_id' => $vehicle->id,
            'slot_id' => $slot->id,
            'parked_by' => Auth::id(),
            'parked_at' => now(),
            'status' => 'parked',
        ]);

        $slot->decrement('available_slots');

        return response()->json([
            'message' => 'Vehicle parked successfully',
            'data' => $parking
        ], 201);
    }

    /**
     * Unpark a vehicle
     */
    public function unpark(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vehicle_number' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $vehicle = Vehicle::where('vehicle_number', strtoupper($request->vehicle_number))->first();

        if (!$vehicle) {
            return response()->json(['message' => 'Vehicle not found'], 404);
        }

        $parking = Parking::where('vehicle_id', $vehicle->id)
            ->where('status', 'parked')
            ->latest()
            ->first();

        if (!$parking) {
            return response()->json(['message' => 'Vehicle is not currently parked'], 400);
        }

        $parking->update([
            'unparked_at' => now(),
            'status' => 'unparked'
        ]);

        $parking->slot->increment('available_slots');

        return response()->json(['message' => 'Vehicle unparked successfully'], 200);
    }

    /**
     * Parking history
     */
    public function history(Request $request)
    {
        $query = Parking::with(['vehicle', 'slot']);

        if ($request->filled('vehicle_number')) {
            $query->whereHas('vehicle', function ($q) use ($request) {
                $q->where('vehicle_number', strtoupper($request->vehicle_number));
            });
        }

        if ($request->filled('from') && $request->filled('to')) {
            $from = Carbon::parse($request->from)->startOfDay();
            $to = Carbon::parse($request->to)->endOfDay();
            $query->whereBetween('parked_at', [$from, $to]);
        }

        if ($request->filled('location')) {
            $query->whereHas('slot', function ($q) use ($request) {
                $q->where('location_name', $request->location);
            });
        }

        $history = $query->orderByDesc('parked_at')->get();

        return response()->json([
            'data' => $history
        ]);
    }
}
