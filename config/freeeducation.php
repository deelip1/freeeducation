<?php

return [
    // ✅ UPDATED: central feature + SEO + AI pipeline controls.
    'features' => [
        'ai_blog_suggestions' => env('FEATURE_AI_BLOG_SUGGESTIONS', true),
        'ai_poster_generator' => env('FEATURE_AI_POSTER_GENERATOR', true),
        'ai_itr_assistant' => env('FEATURE_AI_ITR_ASSISTANT', true),
        'whatsapp_notifications' => env('FEATURE_WHATSAPP_NOTIFICATIONS', false),
        'content_approval_required' => env('FEATURE_CONTENT_APPROVAL_REQUIRED', true),
        'google_oauth' => env('FEATURE_GOOGLE_OAUTH', true),
        'itr_otp_login' => env('FEATURE_ITR_OTP_LOGIN', true),
    ],

    'ai' => [
        'provider' => env('AI_PROVIDER', 'openai'),
        'default_language' => env('AI_DEFAULT_LANGUAGE', 'hi'),
        'max_source_chars' => (int) env('AI_MAX_SOURCE_CHARS', 20000),
    ],

    'itr' => [
        'default_assessment_year' => env('ITR_DEFAULT_ASSESSMENT_YEAR', '2026-27'),
        'compliance_note' => env('ITR_COMPLIANCE_NOTE', 'Review against latest CBDT notifications before final submission.'),
    ],

    'seo' => [
        'default_title' => env('SEO_DEFAULT_TITLE', 'free-education.fun'),
        'meta_description_length' => (int) env('SEO_META_DESCRIPTION_LENGTH', 160),
        'enable_schema_article' => env('SEO_ENABLE_SCHEMA_ARTICLE', true),
    ],

    'storage' => [
        'poster_disk' => env('POSTER_DISK', 's3'),
        'gov_order_disk' => env('GOV_ORDER_DISK', 'local'),
    ],
];
