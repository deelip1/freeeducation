<?php

declare(strict_types=1);

namespace App\Modules\AI\Services;

use App\Services\AI\AiAssistantService;

class AIEngineService
{
    public function __construct(private readonly AiAssistantService $ai)
    {
    }

    // ✅ UPDATED: reusable AI blog generation contract for CMS/editor.
    public function generateBlogDraft(string $topic, string $language = 'hi'): array
    {
        return [
            'title' => $language === 'hi' ? $topic . ' - सम्पूर्ण गाइड' : $topic . ' - Complete Guide',
            'content_prompt' => $this->ai->generateEducationalDraft($topic, $language),
            'seo_hint' => 'Include H2/H3, FAQs, bullets, and practical examples.',
        ];
    }
}
