<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Module;
use Illuminate\Database\Eloquent\Collection;

class ModuleRepository
{
    public function enabled(): Collection
    {
        return Module::query()->where('is_enabled', true)->with('fields')->get();
    }

    public function findBySlug(string $slug): ?Module
    {
        return Module::query()->where('slug', $slug)->with('fields')->first();
    }
}
