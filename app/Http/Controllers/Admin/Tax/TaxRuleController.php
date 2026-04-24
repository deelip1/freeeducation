<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Tax;

use App\Http\Controllers\Controller;
use App\Models\Tax\TaxRule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaxRuleController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(TaxRule::query()->latest()->get());
    }

    public function store(Request $request): JsonResponse
    {
        $payload = $request->validate([
            'assessment_year' => ['required', 'string', 'max:20'],
            'regime' => ['required', 'in:old,new'],
            'slabs' => ['required', 'array', 'min:1'],
            'standard_deduction' => ['nullable', 'numeric', 'min:0'],
            'rebate_threshold' => ['nullable', 'numeric', 'min:0'],
            'rebate_amount' => ['nullable', 'numeric', 'min:0'],
            'cess_percent' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $rule = TaxRule::query()->updateOrCreate([
            'assessment_year' => $payload['assessment_year'],
            'regime' => $payload['regime'],
        ], $payload);

        return response()->json($rule, 201);
    }
}
