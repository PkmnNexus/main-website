<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PokemonTcgCardPrice extends Model
{
    protected $fillable = [
        'card_id',
        'variant_key',
        'variant_type',
        'variant_subtype',
        'variant_data',
        'source',
        'currency',
        'external_product_id',
        'price_data',
        'source_updated_at',
    ];

    protected function casts(): array
    {
        return [
            'variant_data' => 'array',
            'price_data' => 'array',
            'source_updated_at' => 'datetime',
        ];
    }

    public function card(): BelongsTo
    {
        return $this->belongsTo(PokemonTcgCard::class, 'card_id');
    }
}