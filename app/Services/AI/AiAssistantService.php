<?php

declare(strict_types=1);

namespace App\Services\AI;

class AiAssistantService
{
    public function generateEducationalDraft(string $topic, string $language = 'en'): string
    {
        $langInstruction = $language === 'hi' ? 'हिंदी' : 'English';

        // Hook this method with OpenAI or another provider via queued job in production.
        return sprintf(
            'Draft (%s): Create an engaging, factual educational article about "%s" with examples and exam-focused bullet points.',
            $langInstruction,
            $topic
        );
    }

    public function suggestItrForm(array $taxProfile): string
    {
        $businessIncome = (float) ($taxProfile['business_income'] ?? 0);

        return $businessIncome > 0 ? 'ITR-4 (likely)' : 'ITR-1 (likely)';
    }
}
