<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AI\AiAssistantService;
use App\Services\AI\ContentIngestionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContentAiController extends Controller
{
    public function rewrite(Request $request, ContentIngestionService $ingestion, AiAssistantService $ai): JsonResponse
    {
        $validated = $request->validate([
            'language' => ['required', 'in:hi,en'],
            'source_text' => ['nullable', 'string', 'min:50'],
            'source_url' => ['nullable', 'url'],
        ]);

        $raw = (string) ($validated['source_text'] ?? '');
        // NOTE: URL ingestion/scraping should run via queued job + allowlist policy.
        $sanitized = $ingestion->sanitizeSource($raw);
        $facts = $ingestion->extractFacts($sanitized);

        return response()->json([
            'prompt' => $ai->generateRewritePrompt($facts, $validated['language']),
            'approval_required' => (bool) config('freeeducation.features.content_approval_required', true),
        ]);
    }
}
