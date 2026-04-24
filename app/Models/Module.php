<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_enabled',
        'ai_enabled',
        'settings',
    ];

    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
            'ai_enabled' => 'boolean',
            'settings' => 'array',
        ];
    }

    public function fields(): HasMany
    {
        return $this->hasMany(ModuleField::class);
    }
}
