<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PokemonTcgSeries extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Eloquent
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'external_id',
        'api_name',
        'api_logo_url',
        'name',
        'logo_asset_id',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

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
}
