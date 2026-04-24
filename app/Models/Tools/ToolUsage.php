<?php

declare(strict_types=1);

namespace App\Models\Tools;

use Illuminate\Database\Eloquent\Model;

class ToolUsage extends Model
{
    protected $fillable = ['user_id', 'tool_id', 'input_meta', 'output_meta', 'credits_used'];

    protected function casts(): array
    {
        return [
            'input_meta' => 'array',
            'output_meta' => 'array',
        ];
    }
}
