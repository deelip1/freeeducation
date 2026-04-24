<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Tools;

use App\Http\Controllers\Controller;
use App\Models\Tools\AiLog;
use App\Models\Tools\Design;
use App\Services\AI\AiAssistantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SocialCreatorController extends Controller
{
    public function generate(Request $request, AiAssistantService $ai): JsonResponse
    {
        $validated = $request->validate([
            'category' => ['required', 'in:birthday,festival,motivation,cyber-awareness'],
            'language' => ['nullable', 'in:hi,en'],
            'image_path' => ['nullable', 'string', 'max:500'],
        ]);

        $pack = $ai->generateSocialPack($validated['category'], $validated['language'] ?? 'hi');

        $design = Design::query()->create([
            'user_id' => $request->user()?->id,
            'category' => $validated['category'],
            'image_path' => $validated['image_path'] ?? null,
            'caption' => $pack['caption'],
            'quote' => $pack['quote'],
            'hashtags' => implode(' ', $pack['hashtags']),
            'rendered_path' => 'designs/' . uniqid('render_', true) . '.png',
        ]);

        AiLog::query()->create([
            'user_id' => $request->user()?->id,
            'context' => 'social_creator',
            'prompt' => json_encode($validated, JSON_THROW_ON_ERROR),
            'response' => json_encode($pack, JSON_THROW_ON_ERROR),
            'tokens_used' => 0,
        ]);

        return response()->json($design, 201);
    }
}
