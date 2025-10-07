<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('deploy');
});
Route::get('/_debug/ping-web', fn() => response()->json(['ok' => true, 'group' => 'web']));
