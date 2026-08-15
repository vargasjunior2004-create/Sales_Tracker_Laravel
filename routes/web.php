<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $content = file_get_contents(public_path('index.html'));
    return response($content, 200)
        ->header('Content-Type', 'text/html')
        ->header('Cache-Control', 'no-cache');
});
