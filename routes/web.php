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
    Route::get('/cp', [CodeplugController::class, 'index'])->name('cp.index');
    Route::get('/cp/create', [CodeplugController::class, 'create'])->name('cp.create');
    Route::get('/cp/{codeplug}/edit', [CodeplugController::class, 'edit'])->name('cp.edit');

    // Rooms (nested)
    Route::post('/cp/{codeplug}/rooms', [RoomController::class,'store'])->name('rooms.store');
    Route::delete('/cp/{codeplug}/rooms/{room}', [RoomController::class,'destroy'])->name('rooms.destroy');

    // Access IDs
    Route::get('/access', [AccessIdController::class, 'index'])->name('access.index');
    Route::get('/access/create', [AccessIdController::class, 'create'])->name('access.create');
    Route::get('/access/{accessId}/edit', [AccessIdController::class, 'edit'])->name('access.edit');

});

// Admin placeholder (already working)
Route::middleware(['web', 'auth', 'ensure.superuser'])->group(function () {
    Route::view('/admin', 'admin.index')->name('admin.index');
});

require __DIR__.'/auth.php';



