<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CodeplugController;

Route::prefix('v1')->group(function () {
    Route::get('ping', fn () => response()->json(['pong' => true]));

    // POST /api/v1/auth   { "access_id": "1321" }
    Route::post('auth', [AuthController::class, 'auth'])->name('api.auth');

    // GET /api/v1/codeplug with headers X-Access-ID and X-Access-Token
    Route::get('codeplug', [CodeplugController::class, 'show'])->name('api.codeplug');
});
