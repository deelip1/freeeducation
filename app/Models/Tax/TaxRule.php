<?php

declare(strict_types=1);

namespace App\Models\Tax;

use Illuminate\Database\Eloquent\Model;

class TaxRule extends Model
{
    protected $fillable = [
        'assessment_year',
        'regime',
        'slabs',
        'standard_deduction',
        'rebate_threshold',
        'rebate_amount',
        'cess_percent',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'slabs' => 'array',
            'standard_deduction' => 'decimal:2',
            'rebate_threshold' => 'decimal:2',
            'rebate_amount' => 'decimal:2',
            'cess_percent' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }
}
