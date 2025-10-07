<?php

use App\Http\Controllers\CodeplugController;

Route::get('/codeplug', [CodeplugController::class, 'show'])
    ->middleware('auth:sanctum');