<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MachineTelemetry extends Model
{
    protected $fillable = [
        'temperature',
        'heater_status',
        'connection_status',
        'source',
        'received_at',
    ];

    protected function casts(): array
    {
        return [
            'temperature' => 'float',
            'received_at' => 'datetime',
        ];
    }
}
