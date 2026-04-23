<?php

declare(strict_types=1);

namespace App\Services\AI;

class AiAssistantService
{
    // ✅ UPDATED: default Hindi-first generation with structured output instructions.
    public function generateEducationalDraft(string $topic, string $language = ''): string
    {
        $finalLanguage = $language !== '' ? $language : (string) config('freeeducation.ai.default_language', 'hi');
        $langInstruction = $finalLanguage === 'hi' ? 'Hindi (देवनागरी)' : 'English';

        return sprintf(
            'Generate a unique educational article in %s on "%s" with H2/H3 headings, bullet points, key takeaways, FAQ, and exam-focused examples.',
            $langInstruction,
            $topic
        );
    }

    // ✅ UPDATED: supports clean rewrite pipeline instructions.
    public function generateRewritePrompt(string $sanitizedFacts, string $language): string
    {
        $langInstruction = $language === 'hi' ? 'Hindi (देवनागरी)' : 'English';

        return "Rewrite into {$langInstruction}. Use only factual meaning from input, add educational context, headings, sub-headings, bullet points, and do not copy original sentence structure.\nFacts:\n" . $sanitizedFacts;
    }

    public function suggestItrForm(array $taxProfile): string
    {
        $businessIncome = (float) ($taxProfile['business_income'] ?? 0);

        return $businessIncome > 0 ? 'ITR-4 (likely)' : 'ITR-1 (likely)';
    }
}
