<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MachineConfiguration extends Model
{
    protected $fillable = [
        'user_id',
        'payload',
        'status',
        'response',
    ];

    protected function casts(): array
    {
        return [
            'payload' => 'array',
            'response' => 'array',
        ];
    }
}
