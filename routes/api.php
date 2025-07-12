<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ParkingController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/park', [ParkingController::class, 'park']);
    Route::post('/unpark', [ParkingController::class, 'unpark']);
    Route::get('/parking-history', [ParkingController::class, 'history']);
});


