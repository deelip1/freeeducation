<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AI\AiAssistantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function suggestContent(Request $request, AiAssistantService $ai): JsonResponse
    {
        $validated = $request->validate([
            'topic' => ['required', 'string', 'max:160'],
            'language' => ['required', 'string', 'in:en,hi'],
        ]);

        return response()->json([
            'suggestion' => $ai->generateEducationalDraft(
                $validated['topic'],
                $validated['language']
            ),
        ]);
    }
}
