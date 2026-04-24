<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Cms;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Tag;
use App\Modules\CMS\Services\CmsEngineService;
use App\Services\SEO\SeoMetaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function __construct(private readonly CmsEngineService $cms)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json($this->cms->publishedFeed(12));
    }

    public function store(Request $request, SeoMetaService $seo): JsonResponse
    {
        $payload = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:blog_categories,id'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:80'],
            'is_featured' => ['boolean'],
            'publish_at' => ['nullable', 'date'],
        ]);

        $slug = Str::slug($payload['title']) . '-' . Str::lower(Str::random(6));

        $post = new BlogPost([
            'author_id' => $request->user()->id,
            'category_id' => $payload['category_id'] ?? null,
            'title' => $payload['title'],
            'slug' => $slug,
            'excerpt' => $payload['excerpt'] ?? null,
            'content' => $payload['content'],
            'is_featured' => $payload['is_featured'] ?? false,
            'approval_status' => config('freeeducation.features.content_approval_required', true) ? 'pending' : 'approved',
            'published_at' => $payload['publish_at'] ?? null,
        ]);

        $canonical = url($this->cms->canonicalPath($post));
        $post->seo_meta = $seo->articleMeta($payload['title'], $payload['content'], $canonical);
        $post->schema_meta = $seo->articleSchema(['title' => $payload['title'], 'author_name' => (string) $request->user()?->name]);
        $post->save();

        $tagIds = collect($payload['tags'] ?? [])->map(fn (string $tag): int =>
            Tag::query()->firstOrCreate(['slug' => Str::slug($tag)], ['name' => $tag])->id
        )->all();

        $post->tags()->sync($tagIds);

        return response()->json($post->load('tags'), 201);
    }
}
