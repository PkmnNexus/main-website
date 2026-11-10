<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Trivia extends Model
{
    use HasTranslations;
    use SoftDeletes;

    protected $table = 'trivia';

    public array $translatable = [
        'fact',
    ];

    protected $fillable = [
        'fact',
        'hero_asset_id',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function heroImage(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'hero_asset_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
