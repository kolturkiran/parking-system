@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Parking System Dashboard</h2>

    <div class="mb-4">
        <strong>Total Vehicles:</strong> {{ $totalVehicles }} <br>
        <strong>Currently Parked:</strong> {{ $currentlyParked }}
    </div>

    <h4>Available Slots by Location</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Location</th>
                <th>Total Slots</th>
                <th>Available Slots</th>
            </tr>
        </thead>
        <tbody>
            @foreach($locations as $loc)
                <tr>
                    <td>{{ $loc->location_name }}</td>
                    <td>{{ $loc->total_slots }}</td>
                    <td>{{ $loc->available_slots }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
