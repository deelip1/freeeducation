<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Tax;

use App\Http\Controllers\Controller;
use App\Models\Tax\ItrFiling;
use App\Models\Tax\ItrProfile;
use App\Services\AI\AiAssistantService;
use App\Services\Tax\ItrComputationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ItrController extends Controller
{
    public function saveProfile(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'pan' => ['required', 'string', 'size:10', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/'],
            'aadhaar' => ['nullable', 'string', 'min:12', 'max:16'],
            'dob' => ['required', 'date'],
            'residential_status' => ['required', 'in:resident,nri'],
            'employment_type' => ['required', 'in:salaried,business,professional,other'],
        ]);

        $profile = ItrProfile::query()->updateOrCreate([
            'user_id' => $request->user()->id,
            'pan' => strtoupper($validated['pan']),
        ], [
            'aadhaar_encrypted' => isset($validated['aadhaar']) ? Crypt::encryptString($validated['aadhaar']) : null,
            'dob' => $validated['dob'],
            'residential_status' => $validated['residential_status'],
            'employment_type' => $validated['employment_type'],
            'aadhaar_linked' => isset($validated['aadhaar']),
        ]);

        return response()->json($profile, 201);
    }

    public function compute(Request $request, ItrComputationService $tax, AiAssistantService $ai): JsonResponse
    {
        $validated = $request->validate([
            'assessment_year' => ['required', 'string', 'max:20'],
            'itr_profile_id' => ['required', 'integer', 'exists:itr_profiles,id'],
            'income' => ['required', 'array'],
            'income.salary_income' => ['nullable', 'numeric', 'min:0'],
            'income.house_property_income' => ['nullable', 'numeric'],
            'income.business_income' => ['nullable', 'numeric', 'min:0'],
            'income.capital_gains' => ['nullable', 'numeric', 'min:0'],
            'income.other_sources_income' => ['nullable', 'numeric', 'min:0'],
            'deductions' => ['nullable', 'array'],
            'credits' => ['nullable', 'array'],
            'submit_for_approval' => ['nullable', 'boolean'],
        ]);

        $profile = ItrProfile::query()->where('id', $validated['itr_profile_id'])->where('user_id', $request->user()->id)->firstOrFail();
        $income = $validated['income'];
        $deductions = $validated['deductions'] ?? [];
        $credits = $validated['credits'] ?? [];

        $comparison = $tax->compareRegimes($income, $deductions, $credits, $validated['assessment_year']);
        $itrForm = $tax->suggestItrForm($income, $profile->employment_type);
        $taxSavingTips = $ai->suggestTaxSavings($income, $deductions);

        $filing = ItrFiling::query()->create([
            'user_id' => $request->user()->id,
            'itr_profile_id' => $profile->id,
            'assessment_year' => $validated['assessment_year'],
            'income_payload' => $income,
            'deduction_payload' => $deductions,
            'tax_credit_payload' => $credits,
            'computation_result' => $comparison,
            'itr_form' => $itrForm,
            'recommended_regime' => $comparison['recommended_regime'],
            'approval_status' => ($validated['submit_for_approval'] ?? false) ? 'pending' : 'draft',
            'submitted_at' => ($validated['submit_for_approval'] ?? false) ? now() : null,
        ]);

        return response()->json([
            'filing_id' => $filing->id,
            'comparison' => $comparison,
            'itr_form' => $itrForm,
            'tax_saving_suggestions' => $taxSavingTips,
            'documents' => [
                'computation_sheet' => $this->computationSheet($filing),
                'form16_summary' => $this->form16LikeSummary($filing),
                'itr_draft_json' => $this->itrDraftJson($filing),
            ],
        ]);
    }

    private function computationSheet(ItrFiling $filing): array
    {
        return [
            'assessment_year' => $filing->assessment_year,
            'income' => $filing->income_payload,
            'deductions' => $filing->deduction_payload,
            'result' => $filing->computation_result,
        ];
    }

    private function form16LikeSummary(ItrFiling $filing): array
    {
        return [
            'salary_income' => $filing->income_payload['salary_income'] ?? 0,
            'tds' => $filing->tax_credit_payload['tds'] ?? 0,
            'standard_deduction' => $filing->deduction_payload['standard_deduction'] ?? 0,
            'net_tax_payable' => $filing->computation_result[$filing->recommended_regime . '_regime']['net_tax_payable'] ?? 0,
        ];
    }

    private function itrDraftJson(ItrFiling $filing): array
    {
        return [
            'form_type' => $filing->itr_form,
            'assessment_year' => $filing->assessment_year,
            'regime' => $filing->recommended_regime,
            'payload' => [
                'income' => $filing->income_payload,
                'deductions' => $filing->deduction_payload,
                'credits' => $filing->tax_credit_payload,
            ],
        ];
    }
}
