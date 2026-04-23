<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsAnnouncement extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'announcement_type',
        'effective_from',
        'effective_to',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'effective_from' => 'datetime',
            'effective_to' => 'datetime',
            'is_published' => 'boolean',
        ];
    }
}
