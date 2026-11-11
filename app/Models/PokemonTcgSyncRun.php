<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PokemonTcgSyncRun extends Model
{
    protected $fillable = [
        'sync_type',
        'status',
        'total',
        'processed',
        'created',
        'updated',
        'skipped',
        'failed',
        'error_message',
        'started_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }
}