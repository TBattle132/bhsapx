<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CodeplugController;
use App\Http\Controllers\AccessIdController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Public welcome
Route::view('/', 'welcome')->name('welcome');

// Auth-only area
Route::middleware(['auth'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Codeplugs
    Route::get('/cp', [CodeplugController::class, 'index'])->name('cp.index');
    Route::get('/cp/create', [CodeplugController::class, 'create'])->name('cp.create');
    Route::post('/cp', [CodeplugController::class, 'store'])->name('cp.store');
    Route::get('/cp/{codeplug}/edit', [CodeplugController::class, 'edit'])->name('cp.edit');
    Route::put('/cp/{codeplug}', [CodeplugController::class, 'update'])->name('cp.update');
    Route::delete('/cp/{codeplug}', [CodeplugController::class, 'destroy'])->name('cp.destroy');

    // Access IDs
    Route::get('/access', [AccessIdController::class, 'index'])->name('access.index');
    Route::get('/access/create', [AccessIdController::class, 'create'])->name('access.create');
    Route::post('/access', [AccessIdController::class, 'store'])->name('access.store');
    Route::get('/access/{access}/edit', [AccessIdController::class, 'edit'])->name('access.edit');
    Route::put('/access/{access}', [AccessIdController::class, 'update'])->name('access.update');
    Route::delete('/access/{access}', [AccessIdController::class, 'destroy'])->name('access.destroy');

    // Logout (Breeze uses POST)
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// Superuser area
Route::middleware(['auth', 'ensure.superuser'])->group(function () {
    Route::view('/admin', 'admin.index')->name('admin.index');
});

// Breeze routes (login/register/etc)
require __DIR__.'/auth.php';
