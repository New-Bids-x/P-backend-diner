<?php

use Illuminate\Support\Facades\Route;

Route::get('images/{filename}', function ($filename) {
    $path = public_path('images/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
});
