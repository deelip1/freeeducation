<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BlogPost extends Model
{
    protected $fillable = [
        'author_id',
        'category_id',
        'title',
        'featured_image_path',
        'slug',
        'excerpt',
        'content',
        'seo_meta',
        'schema_meta',
        'is_featured',
        'approval_status',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'seo_meta' => 'array',
            'schema_meta' => 'array',
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'blog_post_tag');
    }
}
