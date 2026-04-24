<?php

use App\Http\Controllers\Api\AI\BlogGeneratorController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\Cms\PostController;
use App\Http\Controllers\Api\ContentAiController;
use App\Http\Controllers\Api\Tax\ItrController;
use App\Http\Controllers\Api\Tools\PdfToolController;
use App\Http\Controllers\Api\Tools\SocialCreatorController;
use App\Http\Controllers\Api\ContentAiController;
use App\Http\Controllers\Api\Tax\ItrController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'throttle:api'])->group(function (): void {
    Route::post('/blog/suggest', [BlogController::class, 'suggestContent']);
    Route::post('/content/rewrite', [ContentAiController::class, 'rewrite']);
    Route::post('/ai/blog/generate', [BlogGeneratorController::class, 'generate']);

    Route::get('/cms/posts', [PostController::class, 'index']);
    Route::post('/cms/posts', [PostController::class, 'store']);

    Route::post('/tools/pdf/compress', [PdfToolController::class, 'compress']);
    Route::post('/tools/social/generate', [SocialCreatorController::class, 'generate']);


    // ✅ UPDATED: WordPress-like CMS APIs.
    Route::get('/cms/posts', [PostController::class, 'index']);
    Route::post('/cms/posts', [PostController::class, 'store']);

    // ✅ UPDATED: Tools APIs.
    Route::post('/tools/pdf/compress', [PdfToolController::class, 'compress']);
    Route::post('/tools/social/generate', [SocialCreatorController::class, 'generate']);

// In routes/api.php
Route::post('/content/rewrite', [ContentAiController::class, 'rewrite'])->middleware('premium');

// ✅ UPDATED: ITR filing APIs.
    Route::post('/itr/profile', [ItrController::class, 'saveProfile']);
    Route::post('/itr/compute', [ItrController::class, 'compute']);
});
