<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Region Route Group
Route::controller(App\Http\Controllers\RegionController::class)
    ->prefix('region')->middleware([])
    ->group(function () {
        Route::get('/', 'show')->middleware([]);
        Route::post('/', 'store')->middleware([]);
        Route::get('/', 'index')->middleware([]);
        Route::post('/', 'store')->middleware([]);
        Route::get('/{region}', 'show')->middleware([]);
        Route::put('/{region}', 'update')->middleware([]);
        Route::delete('/{region}', 'destroy')->middleware([]);
        Route::put('/{region}/restore', 'restore')->middleware([]);
        Route::delete('/{region}/force-destory', 'forceDestroy')->middleware([]);
    });
 

// City Route Group
Route::controller(App\Http\Controllers\CityController::class)
    ->prefix('city')->middleware([])
    ->group(function () {
        Route::get('/', 'show')->middleware([]);
        Route::post('/', 'store')->middleware([]);
        Route::get('/', 'index')->middleware([]);
        Route::post('/', 'store')->middleware([]);
        Route::get('/{city}', 'show')->middleware([]);
        Route::put('/{city}', 'update')->middleware([]);
        Route::delete('/{city}', 'destroy')->middleware([]);
        Route::put('/{city}/restore', 'restore')->middleware([]);
        Route::delete('/{city}/force-destory', 'forceDestroy')->middleware([]);
    });
 

// Incident Route Group
Route::controller(App\Http\Controllers\IncidentController::class)
    ->prefix('incident')->middleware([])
    ->group(function () {
        Route::get('/', 'show')->middleware([]);
        Route::post('/', 'store')->middleware([]);
        Route::get('/', 'index')->middleware([]);
        Route::post('/', 'store')->middleware([]);
        Route::get('/{incident}', 'show')->middleware([]);
        Route::put('/{incident}', 'update')->middleware([]);
        Route::delete('/{incident}', 'destroy')->middleware([]);
        Route::put('/{incident}/restore', 'restore')->middleware([]);
        Route::delete('/{incident}/force-destory', 'forceDestroy')->middleware([]);
    });
 

// Country Route Group
Route::controller(App\Http\Controllers\CountryController::class)
    ->prefix('country')->middleware([])
    ->group(function () {
        Route::get('/', 'show')->middleware([]);
        Route::post('/', 'store')->middleware([]);
        Route::get('/', 'index')->middleware([]);
        Route::post('/', 'store')->middleware([]);
        Route::get('/{country}', 'show')->middleware([]);
        Route::put('/{country}', 'update')->middleware([]);
        Route::delete('/{country}', 'destroy')->middleware([]);
        Route::put('/{country}/restore', 'restore')->middleware([]);
        Route::delete('/{country}/force-destory', 'forceDestroy')->middleware([]);
    });
 

