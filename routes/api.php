<?php

use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\ContentAiController;
use App\Http\Controllers\Api\Tax\ItrController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'throttle:api'])->group(function (): void {
    Route::post('/blog/suggest', [BlogController::class, 'suggestContent']);
    Route::post('/content/rewrite', [ContentAiController::class, 'rewrite']);

    // ✅ UPDATED: ITR filing APIs.
    Route::post('/itr/profile', [ItrController::class, 'saveProfile']);
    Route::post('/itr/compute', [ItrController::class, 'compute']);
});
