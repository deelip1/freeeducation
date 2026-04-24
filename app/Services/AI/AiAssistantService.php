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

    // ✅ UPDATED: AI hinting for tax-saving deductions.
    public function suggestTaxSavings(array $income, array $deductions): array
    {
        $suggestions = [];
        if ((float) ($deductions['section_80c'] ?? 0) < 150000) {
            $suggestions[] = 'You may optimize Section 80C up to ₹1,50,000 (PPF/ELSS/LIC).';
        }
        if ((float) ($deductions['section_80d'] ?? 0) < 25000) {
            $suggestions[] = 'Consider medical insurance deduction under Section 80D.';
        }
        if ((float) ($income['salary_income'] ?? 0) > 0) {
            $suggestions[] = 'Validate HRA, standard deduction, and Form-16 consistency before filing.';
        }

        return $suggestions;
    }

    // ✅ UPDATED: social media creator text generation payload.
    public function generateSocialPack(string $category, string $language = 'hi'): array
    {
        $isHindi = $language === 'hi';

        return [
            'caption' => $isHindi
                ? "{$category} के लिए प्रेरक संदेश तैयार है।"
                : "Your {$category} post is ready with an engaging message.",
            'quote' => $isHindi
                ? 'ज्ञान और जागरूकता ही सबसे बड़ी शक्ति है।'
                : 'Awareness and learning are your strongest powers.',
            'hashtags' => $isHindi
                ? ['#शिक्षा', '#प्रेरणा', '#DigitalIndia', '#FreeEducationFun']
                : ['#Education', '#Motivation', '#DigitalIndia', '#FreeEducationFun'],
        ];
    }
}
