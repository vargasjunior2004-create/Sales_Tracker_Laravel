<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $path = public_path('index.html');
    if (file_exists($path)) {
        return response()->file($path);
    }
    return response('Sales Tracker', 200)->header('Content-Type', 'text/plain');
});
