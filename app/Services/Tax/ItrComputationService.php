<?php

declare(strict_types=1);

namespace App\Services\Tax;

class ItrComputationService
{
    public function compute(array $input): array
    {
        $salary = (float) ($input['salary_income'] ?? 0);
        $other = (float) ($input['other_income'] ?? 0);
        $deductions = (float) ($input['deductions'] ?? 0);

        $totalIncome = max(0, $salary + $other - $deductions);
        $tax = $this->estimateTax($totalIncome);

        return [
            'taxable_income' => $totalIncome,
            'estimated_tax' => $tax,
            'regime' => 'new',
        ];
    }

    private function estimateTax(float $income): float
    {
        if ($income <= 700000) {
            return 0;
        }

        if ($income <= 1200000) {
            return ($income - 700000) * 0.1;
        }

        return 50000 + (($income - 1200000) * 0.2);
    }
}
