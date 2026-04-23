<?php

use App\Http\Controllers\Api\BlogController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'throttle:api'])->group(function (): void {
    Route::post('/blog/suggest', [BlogController::class, 'suggestContent']);
});
