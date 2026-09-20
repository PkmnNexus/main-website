<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MediaFolder extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'icon',
        'color',
        'sort_order',
        'is_system',
    ];

    protected static function booted(): void
    {
        static::creating(function (MediaFolder $folder): void {
            if (blank($folder->slug)) {
                $folder->slug = str($folder->name)->slug();
            }
        });
    }

    protected function casts(): array
    {
        return [
            'is_system' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeRoots(Builder $query): Builder
    {
        return $query
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->orderBy('name');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isRoot(): bool
    {
        return $this->parent_id === null;
    }

    public function hasChildren(): bool
    {
        return $this->relationLoaded('children')
            ? $this->children->isNotEmpty()
            : $this->children()->exists();
    }

    public function getDepthAttribute(): int
    {
        $depth = 0;

        $parent = $this->parent;

        while ($parent) {
            $depth++;
            $parent = $parent->parent;
        }

        return $depth;
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')
            ->orderBy('sort_order')
            ->orderBy('name');
    }

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }
}