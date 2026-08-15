<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $path = public_path('index.html');
    if (file_exists($path)) {
        return response(file_get_contents($path), 200)
            ->header('Content-Type', 'text/html')
            ->header('Cache-Control', 'no-cache');
    }
    abort(404, 'index.html not found at: ' . $path);
});
