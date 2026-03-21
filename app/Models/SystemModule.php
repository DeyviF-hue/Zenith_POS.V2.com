<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemModule extends Model
{
    protected $fillable = [
        'module_key',
        'module_name',
        'icon',
        'description',
        'enabled',
    ];

    protected $casts = [
        'enabled' => 'boolean',
    ];
}
