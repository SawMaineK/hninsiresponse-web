<?php

use Illuminate\Support\Facades\Route;
use Sawmainek\Apitoolz\Http\Controllers\FileStorageController;

Route::view('/{path?}', 'apitoolz::app');

Route::get('/img/{path}', [FileStorageController::class, 'image'])->where('path', '.*');
Route::get('/file/{path}', [FileStorageController::class, 'file'])->where('path', '.*');