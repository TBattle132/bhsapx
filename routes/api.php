<?php

use App\Http\Controllers\CodeplugController;
use App\Http\Controllers\Api\CodeplugLookupController;

Route::middleware('auth:sanctum')->get('/codeplug', [CodeplugLookupController::class, 'showByAccessId']);

Route::get('/codeplug', [CodeplugController::class, 'show'])
    ->middleware('auth:sanctum');