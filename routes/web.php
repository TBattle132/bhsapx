<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureSuperuser;
use App\Http\Controllers\CodeplugController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\AccessIdController;

Route::get('/', fn() => redirect()->route('dashboard'));

Route::middleware(['auth'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Codeplugs
    Route::get('/cp', [CodeplugController::class,'index'])->name('cp.index');
    Route::get('/cp/create', [CodeplugController::class,'create'])->name('cp.create');
    Route::post('/cp', [CodeplugController::class,'store'])->name('cp.store');
    Route::get('/cp/{codeplug}/edit', [CodeplugController::class,'edit'])->name('cp.edit');
    Route::put('/cp/{codeplug}', [CodeplugController::class,'update'])->name('cp.update');
    Route::delete('/cp/{codeplug}', [CodeplugController::class,'destroy'])->name('cp.destroy');

    // Rooms (nested)
    Route::post('/cp/{codeplug}/rooms', [RoomController::class,'store'])->name('rooms.store');
    Route::delete('/cp/{codeplug}/rooms/{room}', [RoomController::class,'destroy'])->name('rooms.destroy');

    // Access IDs
    Route::get('/access',               [AccessIdController::class, 'index'])->name('access.index');
    Route::get('/access/create',        [AccessIdController::class, 'create'])->name('access.create');
    Route::post('/access',              [AccessIdController::class, 'store'])->name('access.store');
    Route::get('/access/{access}/edit', [AccessIdController::class, 'edit'])->name('access.edit');
    Route::put('/access/{access}',      [AccessIdController::class, 'update'])->name('access.update');
    Route::delete('/access/{access}',   [AccessIdController::class, 'destroy'])->name('access.destroy');
});

// Admin placeholder (already working)
Route::middleware(['auth', EnsureSuperuser::class])->group(function () {
    Route::view('/admin', 'admin.index')->name('admin.index');
});

require __DIR__.'/auth.php';



