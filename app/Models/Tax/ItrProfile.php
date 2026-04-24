<?php

declare(strict_types=1);

namespace App\Models\Tax;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItrProfile extends Model
{
    protected $fillable = [
        'user_id',
        'pan',
        'aadhaar_encrypted',
        'dob',
        'residential_status',
        'employment_type',
        'aadhaar_linked',
    ];

    protected function casts(): array
    {
        return [
            'dob' => 'date',
            'aadhaar_linked' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function filings(): HasMany
    {
        return $this->hasMany(ItrFiling::class);
    }
}
