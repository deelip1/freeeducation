<?php

declare(strict_types=1);

namespace App\Models\Tax;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItrFiling extends Model
{
    protected $fillable = [
        'user_id',
        'itr_profile_id',
        'assessment_year',
        'income_payload',
        'deduction_payload',
        'tax_credit_payload',
        'computation_result',
        'itr_form',
        'recommended_regime',
        'approval_status',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'income_payload' => 'array',
            'deduction_payload' => 'array',
            'tax_credit_payload' => 'array',
            'computation_result' => 'array',
            'submitted_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(ItrProfile::class, 'itr_profile_id');
    }
}
