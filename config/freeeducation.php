<?php

return [
    'features' => [
        'ai_blog_suggestions' => env('FEATURE_AI_BLOG_SUGGESTIONS', true),
        'ai_poster_generator' => env('FEATURE_AI_POSTER_GENERATOR', true),
        'ai_itr_assistant' => env('FEATURE_AI_ITR_ASSISTANT', true),
        'whatsapp_notifications' => env('FEATURE_WHATSAPP_NOTIFICATIONS', false),
    ],
    'storage' => [
        'poster_disk' => env('POSTER_DISK', 's3'),
        'gov_order_disk' => env('GOV_ORDER_DISK', 'local'),
    ],
];
