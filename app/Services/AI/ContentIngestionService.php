<?php

declare(strict_types=1);

namespace App\Services\AI;

use Illuminate\Support\Str;

class ContentIngestionService
{
    // ✅ UPDATED: sanitize pasted/source text for safe AI processing.
    public function sanitizeSource(string $raw): string
    {
        $clean = strip_tags($raw);
        $clean = preg_replace('/\s+/', ' ', $clean) ?? '';
        $clean = trim($clean);

        return Str::limit($clean, (int) config('freeeducation.ai.max_source_chars', 20000), '');
    }

    public function extractFacts(string $sanitized): string
    {
        // Placeholder: in production, add NLP extractor pipeline/job.
        return $sanitized;
    }
}
