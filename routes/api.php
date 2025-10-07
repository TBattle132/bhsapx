<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CodeplugController;

Route::get('/health', fn () => response()->json(['ok' => true]));

// Versioned API
Route::prefix('v1')->group(function () {
    Route::post('/auth', [AuthController::class, 'auth'])->name('api.v1.auth');
    Route::get('/codeplug', [CodeplugController::class, 'show'])->name('api.v1.codeplug');
});
