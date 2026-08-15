<?php

use Illuminate\Support\Facades\Route;

// SPA catch-all - disabled session middleware to avoid 500 on Render
Route::get('/', function () {
    $content = file_get_contents(public_path('index.html'));
    return response($content, 200)
        ->header('Content-Type', 'text/html')
        ->header('Cache-Control', 'no-cache');
})->withoutMiddleware([\Illuminate\Session\Middleware\StartSession::class]);
