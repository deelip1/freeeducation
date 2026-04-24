<?php

declare(strict_types=1);

namespace App\Modules\Tools\Services;

use App\Models\Tools\Tool;

class ToolsEngineService
{
    public function getOrCreateTool(string $slug, string $name, string $type, array $settings = []): Tool
    {
        return Tool::query()->firstOrCreate(['slug' => $slug], [
            'name' => $name,
            'tool_type' => $type,
            'settings' => $settings,
            'is_active' => true,
        ]);
    }
}
