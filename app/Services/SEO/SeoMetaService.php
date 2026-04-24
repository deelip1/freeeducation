<?php

declare(strict_types=1);

namespace App\Services\SEO;

use Illuminate\Support\Str;

class SeoMetaService
{
    public function articleMeta(string $title, string $content, string $canonicalUrl): array
    {
        $descriptionLen = (int) config('freeeducation.seo.meta_description_length', 160);

        return [
            'title' => $title,
            'description' => Str::limit(trim(strip_tags($content)), $descriptionLen),
            'canonical' => $canonicalUrl,
        ];
    }

    public function articleSchema(array $post): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $post['title'] ?? '',
            'datePublished' => $post['published_at'] ?? now()->toAtomString(),
            'author' => ['@type' => 'Person', 'name' => $post['author_name'] ?? 'Team'],
        ];
    }
}
