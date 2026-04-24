<?php

declare(strict_types=1);

namespace App\Models\Tools;

use Illuminate\Database\Eloquent\Model;

class AiLog extends Model
{
    protected $fillable = ['user_id', 'context', 'prompt', 'response', 'tokens_used'];
}
