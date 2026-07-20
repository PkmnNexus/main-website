<?php

namespace App\Models;

use App\Contracts\Seoable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Page extends Model implements HasMedia, Seoable
{
    use InteractsWithMedia;

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

    protected $casts = [
        'is_active' => 'boolean',
        'robots_index' => 'boolean',
        'robots_follow' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('ogImage')
            ->singleFile();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getSeoTitleSource(): ?string
    {
        return $this->title;
    }

    public function getSeoExcerptSource(): ?string
    {
        return null;
    }

    public function getSeoDescriptionSource(): ?string
    {
        return $this->meta_description;
    }

    public function getSeoKeywordsSource(): ?string
    {
        return $this->meta_keywords;
    }

    public function getSeoRobotsSource(): ?string
    {
        return $this->robots;
    }

    public function getSeoCanonicalSource(): ?string
    {
        return $this->canonical;
    }

    public function getSeoOgTitleSource(): ?string
    {
        return $this->og_title;
    }

    public function getSeoOgDescriptionSource(): ?string
    {
        return $this->og_description;
    }

    public function getSeoOgTypeSource(): ?string
    {
        return $this->og_type;
    }

    public function getSeoSchemaType(): string
    {
        return 'WebPage';
    }

    public function getSeoImageSource(): ?string
    {
        return $this->getFirstMediaUrl('ogImage');
    }
}
