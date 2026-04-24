<?php

declare(strict_types=1);

namespace App\Modules\CMS\Services;

use App\Models\BlogPost;

class CmsEngineService
{
    // ✅ UPDATED: central CMS engine methods (publish gates + canonical structure).
    public function publishedFeed(int $limit = 12)
    {
        return BlogPost::query()
            ->where('approval_status', 'approved')
            ->whereNotNull('published_at')
            ->with(['category', 'tags'])
            ->latest('published_at')
            ->paginate($limit);
    }

    public function canonicalPath(BlogPost $post): string
    {
        $categorySlug = $post->category?->slug ?? 'general';

        return '/blog/' . $categorySlug . '/' . $post->slug;
    }
}
