<?php

namespace App\Models;

use App\Contracts\Seoable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Page extends Model implements HasMedia, Seoable
{
    use HasTranslations;
    use InteractsWithMedia;

    /*
    |--------------------------------------------------------------------------
    | Eloquent
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'key',
        'hero_asset_id',
        'page',
        'title',
        'slug',
        'content',
        'meta_description',
        'meta_keywords',
        'canonical',
        'robots_index',
        'robots_follow',
        'og_title',
        'og_description',
        'og_type',
        'is_active',
    ];

    public array $translatable = [
        'slug',
        'content',
        'title',
        'meta_description',
        'meta_keywords',
        'canonical',
        'og_title',
        'og_description',
    ];

    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'is_active' => 'boolean',
        'robots_index' => 'boolean',
        'robots_follow' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Media Collections
    |--------------------------------------------------------------------------
    */

    /**
     * Register the media collections for the page.
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('ogImage')
            ->singleFile();
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the hero image that belongs to the page.
     */
    public function heroImage(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'hero_asset_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SEO Contracts
    |--------------------------------------------------------------------------
    */

    /**
     * Get the source for the SEO title.
     */
    public function getSeoTitleSource(): ?string
    {
        return $this->title;
    }

    /**
     * Get the source for the SEO excerpt.
     */
    public function getSeoExcerptSource(): ?string
    {
        return null;
    }

    /**
     * Get the source for the SEO description.
     */
    public function getSeoDescriptionSource(): ?string
    {
        return $this->meta_description;
    }

    /**
     * Get the source for the SEO keywords.
     */
    public function getSeoKeywordsSource(): ?string
    {
        return $this->meta_keywords;
    }

    /**
     * Get the source for the SEO robots directives.
     */
    public function getSeoRobotsSource(): ?string
    {
        return $this->robots_index && $this->robots_follow
            ? 'index, follow'
            : implode(', ', array_filter([
                $this->robots_index ? 'index' : 'noindex',
                $this->robots_follow ? 'follow' : 'nofollow',
            ]));
    }

    /**
     * Get the source for the SEO canonical URL.
     */
    public function getSeoCanonicalSource(): ?string
    {
        return $this->canonical;
    }

    /**
     * Get the source for the SEO Open Graph title.
     */
    public function getSeoOgTitleSource(): ?string
    {
        return $this->og_title;
    }

    /**
     * Get the source for the SEO Open Graph description.
     */
    public function getSeoOgDescriptionSource(): ?string
    {
        return $this->og_description;
    }

    /**
     * Get the source for the SEO Open Graph type.
     */
    public function getSeoOgTypeSource(): ?string
    {
        return $this->og_type;
    }

    /**
     * Get the schema.org type for the SEO metadata.
     */
    public function getSeoSchemaType(): string
    {
        return 'WebPage';
    }

    /**
     * Get the source URL for the SEO image.
     */
    public function getSeoImageSource(): ?string
    {
        return $this->heroImage?->getFirstMediaUrl('asset', 'og-jpg');
    }
}