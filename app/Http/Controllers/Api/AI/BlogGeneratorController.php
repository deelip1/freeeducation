<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\AI;

use App\Http\Controllers\Controller;
use App\Modules\AI\Services\AIEngineService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogGeneratorController extends Controller
{
    public function generate(Request $request, AIEngineService $aiEngine): JsonResponse
    {
        $payload = $request->validate([
            'topic' => ['required', 'string', 'max:180'],
            'language' => ['nullable', 'in:hi,en'],
        ]);

        return response()->json($aiEngine->generateBlogDraft($payload['topic'], $payload['language'] ?? 'hi'));
    }
}
