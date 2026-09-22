<?php

namespace App\Models;

use App\Contracts\Seoable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Page extends Model implements HasMedia, Seoable
{
    use InteractsWithMedia;

    /*
    |--------------------------------------------------------------------------
    | Eloquent
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'title',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'robots_index',
        'robots_follow',
        'canonical',
        'og_title',
        'og_description',
        'og_type',
        'is_active',
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
    | Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

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
        return $this->robots;
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
        return $this->getFirstMediaUrl('ogImage');
    }
}