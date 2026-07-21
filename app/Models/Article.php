<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Contracts\Seoable;

use Spatie\Tags\HasTags;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Article extends Model implements Seoable, HasMedia
{
    use HasFactory, HasTags, InteractsWithMedia;

    protected $guarded = [];

    protected $with = ['tags'];

    protected $casts = [
        'published_at' => 'datetime'
    ];

    public function getSeoTitleSource(): ?string
    {
        return $this->title;
    }

    public function getSeoExcerptSource(): ?string
    {
        return $this->excerpt;
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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sources()
    {
        return $this->belongsToMany(Source::class);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('hero_image')->singleFile();
    }
}