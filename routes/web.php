<?php

use Illuminate\Support\Facades\Route;
use Sawmainek\Apitoolz\Http\Controllers\FileStorageController;

Route::get('/incident/{id}', function ($id) {
    $incident = \App\Models\Incident::find($id);
    if (!$incident) {
        abort(404);
    }
    return view('incident-detail', ['incident' => $incident]);
});
Route::view('/{path?}', 'apitoolz::app');

Route::get('/img/{path}', [FileStorageController::class, 'image'])->where('path', '.*');
Route::get('/file/{path}', [FileStorageController::class, 'file'])->where('path', '.*');

