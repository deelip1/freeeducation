<?php

declare(strict_types=1);

namespace App\Models\Tools;

use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    protected $fillable = ['user_id', 'category', 'image_path', 'caption', 'quote', 'hashtags', 'rendered_path'];
}
