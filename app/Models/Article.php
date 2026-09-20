<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Contracts\Seoable;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use App\Enums\ArticleStatus;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model implements Seoable, HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected static function booted(): void
    {
        static::saving(function (Article $article) {
            $article->reading_time = self::calculateReadingTime($article->content);
        });
    }

    // Eloquent
    protected $guarded = [];

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'category_id',
        'hero_asset_id',
        'video_url',
        'is_breaking',
        'is_featured',
        'is_pokemon_go_featured',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical',
        'robots_index',
        'robots_follow',
        'og_title',
        'og_description',
        'og_type',
        'user_id',
        'status',
        'published_at',
        'expires_at',
        'reading_time',
    ];

    // Casts
    protected function casts(): array
    {
        return [
            'status' => ArticleStatus::class,

            'is_breaking' => 'boolean',
            'is_featured' => 'boolean',
            'is_pokemon_go_featured' => 'boolean',

            'meta_keywords' => 'array',
            'robots_index' => 'boolean',
            'robots_follow' => 'boolean',

            'published_at' => 'datetime',
            'expires_at' => 'datetime',

            'reading_time' => 'integer',
            'views' => 'integer',
        ];
    }

    // Relations
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function heroImage(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'hero_asset_id');
    }

    public static function calculateReadingTime(string $content): int
    {
        $text = strip_tags($content);

        $wordCount = str_word_count($text);

        return max(1, (int) ceil($wordCount / 200));
    }

    // SEO Contracts
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
}