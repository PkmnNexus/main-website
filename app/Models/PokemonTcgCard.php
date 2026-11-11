<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PokemonTcgCard extends Model
{
    protected $fillable = [
        'set_id',
        'external_id',
        'api_local_id',
        'api_name',
        'api_image_url',
        'api_category',
        'api_illustrator',
        'api_rarity',
        'api_hp',
        'api_types',
        'api_dex_ids',
        'api_evolve_from',
        'api_description',
        'api_level',
        'api_stage',
        'api_suffix',
        'api_trainer_type',
        'api_energy_type',
        'api_effect',
        'api_retreat',
        'api_regulation_mark',
        'api_variants',
        'api_variants_detailed',
        'api_abilities',
        'api_attacks',
        'api_weaknesses',
        'api_resistances',
        'api_legal',
        'api_updated_at',
        'api_data',
        'name',
        'image_asset_id',
    ];

    protected function casts(): array
    {
        return [
            'api_types' => 'array',
            'api_dex_ids' => 'array',
            'api_variants' => 'array',
            'api_variants_detailed' => 'array',
            'api_abilities' => 'array',
            'api_attacks' => 'array',
            'api_weaknesses' => 'array',
            'api_resistances' => 'array',
            'api_legal' => 'array',
            'api_updated_at' => 'datetime',
            'api_data' => 'array',
        ];
    }

    public function set(): BelongsTo
    {
        return $this->belongsTo(PokemonTcgSet::class, 'set_id');
    }

    public function imageAsset(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'image_asset_id');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(PokemonTcgCardPrice::class, 'card_id');
    }

    protected function displayName(): Attribute
    {
        return Attribute::get(
            fn (): ?string => $this->name ?: $this->api_name
        );
    }

    protected function displayImageUrl(): Attribute
    {
        return Attribute::get(
            fn (): ?string => $this->imageAsset?->getFirstMediaUrl('asset')
                ?: ($this->api_image_url
                    ? rtrim($this->api_image_url, '/').'/high.webp'
                    : null)
        );
    }

    protected function displayThumbnailUrl(): Attribute
    {
        return Attribute::get(
            fn (): ?string => $this->imageAsset?->getFirstMediaUrl('asset')
                ?: ($this->api_image_url
                    ? rtrim($this->api_image_url, '/').'/low.webp'
                    : null)
        );
    }
}