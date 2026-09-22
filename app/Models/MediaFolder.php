<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MediaFolder extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Booted
    |--------------------------------------------------------------------------
    */

    /**
     * Bootstrap the model and register its model events.
     */
    protected static function booted(): void
    {
        static::creating(function (MediaFolder $folder): void {
            if (blank($folder->slug)) {
                $folder->slug = str($folder->name)->slug();
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Eloquent
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'icon',
        'color',
        'sort_order',
        'is_system',
    ];

    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    /**
     * Get the model's attribute casts.
     *
     * @return array<string, string>
     */
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

    /**
     * Scope the query to root media folders.
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
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the parent media folder.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Get the child media folders.
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')
            ->orderBy('sort_order')
            ->orderBy('name');
    }

    /**
     * Get the assets belonging to the media folder.
     */
    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Determine whether the media folder is a root folder.
     */
    public function isRoot(): bool
    {
        return $this->parent_id === null;
    }

    /**
     * Determine whether the media folder has children.
     */
    public function hasChildren(): bool
    {
        return $this->relationLoaded('children')
            ? $this->children->isNotEmpty()
            : $this->children()->exists();
    }

    /**
     * Get the depth of the media folder in the folder hierarchy.
     */
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
}