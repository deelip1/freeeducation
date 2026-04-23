<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Tax\ItrFiling;
use App\Models\Tax\ItrProfile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'locale',
        'is_approved',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_approved' => 'boolean',
        ];
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    // ✅ UPDATED: OAuth account mapping relation.
    public function socialAccounts(): HasMany
    {
        return $this->hasMany(SocialAccount::class);
    }

    // ✅ UPDATED: Dedicated ITR profile for tax filing workflow.
    public function itrProfile(): HasOne
    {
        return $this->hasOne(ItrProfile::class);
    }

    public function itrFilings(): HasMany
    {
        return $this->hasMany(ItrFiling::class);
    }
}
