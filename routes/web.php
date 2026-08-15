<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $path = base_path('public/index.html');
    if (!file_exists($path)) {
        $path = public_path('index.html');
    }
    if (file_exists($path)) {
        return response(file_get_contents($path), 200)
            ->header('Content-Type', 'text/html')
            ->header('Cache-Control', 'no-cache');
    }
    return response('Sales Tracker - Frontend not built', 500);
});
