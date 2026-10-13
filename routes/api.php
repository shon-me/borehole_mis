<?php

use App\Http\Controllers\LocationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/save_location', [LocationController::class, 'createLocation']);
Route::get('/get_locations', [LocationController::class, 'readLocations']);
Route::get('/get_location/{id}', [LocationController::class, 'readLocation']);
Route::post('/update_location/{id}', [LocationController::class, 'updateLocation']);
Route::delete('/delete_location/{id}', [LocationController::class, 'deleteLocation']);
Route::get('/search_location/{name}', [LocationController::class, 'searchLocation']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
