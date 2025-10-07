<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CodeplugAdminController;
use App\Http\Controllers\Admin\AccessIdAdminController;
use App\Http\Controllers\Frontend\CodeplugController as FrontCodeplugController;
use App\Http\Controllers\Frontend\AccessIdController as FrontAccessIdController;

Route::view('/', 'welcome');

// --- backend (superuser only) ---
Route::middleware(['auth', 'ensure.superuser'])->prefix('admin')->group(function () {
    Route::resource('codeplugs', CodeplugAdminController::class);
    Route::resource('access-ids', AccessIdAdminController::class);
    // add users, rooms, etc.
});

// --- frontend (community admins) ---
Route::middleware(['auth'])->group(function () {
    Route::resource('cp', FrontCodeplugController::class)->except(['show']);      // scoped by account
    Route::resource('access', FrontAccessIdController::class)->except(['show']);  // scoped by account
});
