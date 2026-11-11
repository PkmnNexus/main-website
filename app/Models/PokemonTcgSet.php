<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PokemonTcgSet extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Eloquent
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'external_id',
        'series_id',
        'api_name',
        'api_logo_url',
        'api_symbol_url',
        'api_release_date',
        'api_card_count_total',
        'api_card_count_official',
        'name',
        'logo_asset_id',
        'symbol_asset_id',
    ];

    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [
            'api_release_date' => 'date',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the series that owns the set.
     */
    public function series(): BelongsTo
    {
        return $this->belongsTo(
            PokemonTcgSeries::class,
            'series_id'
        );
    }

    /**
     * Get the custom logo asset.
     */
    public function logoAsset(): BelongsTo
    {
        return $this->belongsTo(
            Asset::class,
            'logo_asset_id'
        );
    }

    /**
     * Get the custom symbol asset.
     */
    public function symbolAsset(): BelongsTo
    {
        return $this->belongsTo(
            Asset::class,
            'symbol_asset_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Attributes
    |--------------------------------------------------------------------------
    */

    /**
     * Get the display name, falling back to the API name.
     */
    protected function displayName(): Attribute
    {
        return Attribute::get(
            fn (): ?string => $this->name ?: $this->api_name
        );
    }

    /**
     * Get the display logo, falling back to the API logo.
     */
    protected function displayLogoUrl(): Attribute
    {
        return Attribute::get(
            fn (): ?string => $this->logoAsset?->getFirstMediaUrl('asset')
                ?: $this->api_logo_url
        );
    }

    /**
     * Get the display symbol, falling back to the API symbol.
     */
    protected function displaySymbolUrl(): Attribute
    {
        return Attribute::get(
            fn (): ?string => $this->symbolAsset?->getFirstMediaUrl('asset')
                ?: $this->api_symbol_url
        );
    }
}