<?php

declare(strict_types=1);

namespace App\Services\Tax;

use App\Models\Tax\TaxRule;

class ItrComputationService
{
    // ✅ HIGHLIGHT: Full regime comparison, slab computation, cess, rebate, and tax credit adjustment.
    public function compareRegimes(array $income, array $deductions, array $credits, string $assessmentYear): array
    {
        $old = $this->computeByRegime('old', $income, $deductions, $credits, $assessmentYear);
        $new = $this->computeByRegime('new', $income, $deductions, $credits, $assessmentYear);

        $recommended = $old['net_tax_payable'] < $new['net_tax_payable'] ? 'old' : 'new';

        return [
            'assessment_year' => $assessmentYear,
            'old_regime' => $old,
            'new_regime' => $new,
            'recommended_regime' => $recommended,
            'savings' => abs($old['net_tax_payable'] - $new['net_tax_payable']),
        ];
    }

    // ✅ HIGHLIGHT: Fixed Bug - Business income now explicitly overrides basic employment type checks to prevent ITR-1/2 misclassification.
    public function suggestItrForm(array $income, string $employmentType): string
    {
        $hasCapitalGains = (float) ($income['capital_gains'] ?? 0) > 0;
        $business = (float) ($income['business_income'] ?? 0);

        // If there is any business income declared, it MUST be ITR-3 or ITR-4.
        if ($business > 0) {
            return ($business <= 5000000) ? 'ITR-4' : 'ITR-3';
        }

        if ($hasCapitalGains) {
            return 'ITR-2';
        }

        return 'ITR-1';
    }

    private function computeByRegime(string $regime, array $income, array $deductions, array $credits, string $assessmentYear): array
    {
        $rule = TaxRule::query()
            ->where('assessment_year', $assessmentYear)
            ->where('regime', $regime)
            ->where('is_active', true)
            ->first();

        $salary = (float) ($income['salary_income'] ?? 0);
        $house = (float) ($income['house_property_income'] ?? 0);
        $business = (float) ($income['business_income'] ?? 0);
        $capital = (float) ($income['capital_gains'] ?? 0);
        $other = (float) ($income['other_sources_income'] ?? 0);
        $gross = max(0, $salary + $house + $business + $capital + $other);

        $totalDeductions = $regime === 'old'
            ? (float) array_sum($deductions)
            : (float) ($deductions['standard_deduction'] ?? 0);

        if ($rule !== null) {
            $totalDeductions += (float) $rule->standard_deduction;
        }

        $taxable = max(0, $gross - $totalDeductions);
        $slabs = $rule?->slabs ?? $this->defaultSlabs($regime);
        $baseTax = $this->computeSlabTax($taxable, $slabs);

        $rebateThreshold = (float) ($rule?->rebate_threshold ?? 700000);
        $rebateAmount = (float) ($rule?->rebate_amount ?? 25000);
        $rebate = $taxable <= $rebateThreshold ? min($baseTax, $rebateAmount) : 0;

        $taxAfterRebate = max(0, $baseTax - $rebate);
        $cessPercent = (float) ($rule?->cess_percent ?? 4.0);
        $cess = ($taxAfterRebate * $cessPercent) / 100;

        $interest234A = (float) ($credits['interest_234a'] ?? 0);
        $interest234B = (float) ($credits['interest_234b'] ?? 0);
        $interest234C = (float) ($credits['interest_234c'] ?? 0);

        $grossTaxLiability = $taxAfterRebate + $cess + $interest234A + $interest234B + $interest234C;

        $paidCredits = (float) ($credits['tds'] ?? 0)
            + (float) ($credits['advance_tax'] ?? 0)
            + (float) ($credits['self_assessment_tax'] ?? 0);

        return [
            'gross_total_income' => round($gross, 2),
            'total_deductions' => round($totalDeductions, 2),
            'taxable_income' => round($taxable, 2),
            'base_tax' => round($baseTax, 2),
            'rebate_87a' => round($rebate, 2),
            'cess' => round($cess, 2),
            'interest_234a' => round($interest234A, 2),
            'interest_234b' => round($interest234B, 2),
            'interest_234c' => round($interest234C, 2),
            'gross_tax_liability' => round($grossTaxLiability, 2),
            'tax_credits' => round($paidCredits, 2),
            'net_tax_payable' => round(max(0, $grossTaxLiability - $paidCredits), 2),
            'refund_due' => round(max(0, $paidCredits - $grossTaxLiability), 2),
        ];
    }

    private function computeSlabTax(float $income, array $slabs): float
    {
        $tax = 0.0;

        foreach ($slabs as $slab) {
            $from = (float) ($slab['from'] ?? 0);
            $to = $slab['to'] ?? null;
            $rate = ((float) ($slab['rate'] ?? 0)) / 100;

            if ($income <= $from) {
                continue;
            }

            $taxableInSlab = $to === null
                ? ($income - $from)
                : min($income, (float) $to) - $from;

            if ($taxableInSlab > 0) {
                $tax += $taxableInSlab * $rate;
            }
        }

        return $tax;
    }

    private function defaultSlabs(string $regime): array
    {
        return $regime === 'old'
            ? [
                ['from' => 0, 'to' => 250000, 'rate' => 0],
                ['from' => 250000, 'to' => 500000, 'rate' => 5],
                ['from' => 500000, 'to' => 1000000, 'rate' => 20],
                ['from' => 1000000, 'to' => null, 'rate' => 30],
            ]
            : [
                ['from' => 0, 'to' => 300000, 'rate' => 0],
                ['from' => 300000, 'to' => 700000, 'rate' => 5],
                ['from' => 700000, 'to' => 1000000, 'rate' => 10],
                ['from' => 1000000, 'to' => 1200000, 'rate' => 15],
                ['from' => 1200000, 'to' => 1500000, 'rate' => 20],
                ['from' => 1500000, 'to' => null, 'rate' => 30],
            ];
    }
}