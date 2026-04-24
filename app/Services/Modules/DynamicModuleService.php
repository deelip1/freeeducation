<?php

declare(strict_types=1);

namespace App\Services\Modules;

use App\Models\Module;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Arr;

class DynamicModuleService
{
    public function __construct(private readonly DatabaseManager $db)
    {
    }

    public function listModules()
    {
        return Module::query()->with('fields')->latest()->get();
    }

    public function createModule(array $payload): Module
    {
        return $this->db->transaction(function () use ($payload): Module {
            $module = Module::query()->create([
                'name' => $payload['name'],
                'slug' => $payload['slug'],
                'description' => Arr::get($payload, 'description'),
                'is_enabled' => Arr::get($payload, 'is_enabled', true),
                'ai_enabled' => Arr::get($payload, 'ai_enabled', false),
                'settings' => [],
            ]);

            foreach ($payload['fields'] as $index => $field) {
                $module->fields()->create([
                    'label' => $field['label'],
                    'name' => $field['name'],
                    'field_type' => $field['field_type'],
                    'validation_rules' => $field['validation_rules'] ?? [],
                    'options' => $field['options'] ?? [],
                    'is_required' => $field['is_required'] ?? false,
                    'sort_order' => $index + 1,
                ]);
            }

            return $module->load('fields');
        });
    }
}
