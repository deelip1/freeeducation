<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Modules\DynamicModuleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function __construct(private readonly DynamicModuleService $moduleService)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json($this->moduleService->listModules());
    }

    public function store(Request $request): JsonResponse
    {
        $payload = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['required', 'string', 'max:120', 'alpha_dash'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_enabled' => ['boolean'],
            'ai_enabled' => ['boolean'],
            'fields' => ['required', 'array', 'min:1'],
            'fields.*.label' => ['required', 'string', 'max:100'],
            'fields.*.name' => ['required', 'string', 'max:100', 'alpha_dash'],
            'fields.*.field_type' => ['required', 'string', 'in:text,textarea,number,date,select,file,boolean'],
            'fields.*.is_required' => ['boolean'],
            'fields.*.validation_rules' => ['array'],
            'fields.*.options' => ['array'],
        ]);

        $module = $this->moduleService->createModule($payload);

        return response()->json($module, 201);
    }
}
