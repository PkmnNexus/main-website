<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Facades\DB;

use App\Contracts\Seoable;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Tags\HasTags;

use App\Enums\ArticleStatus;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model implements Seoable, HasMedia
{
    use HasFactory, InteractsWithMedia, HasTags;

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
        static::saving(function (Article $article): void {
            $article->reading_time = filled($article->content)
                ? self::calculateReadingTime($article->content)
                : null;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Eloquent
    |--------------------------------------------------------------------------
    */

    protected $guarded = [];

    protected $with = ['tags'];

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'summary',
        'content',
        'category_id',
        'hero_asset_id',
        'video_url',
        'youtube_published_at',
        'youtube_thumbnail_url',
        'youtube_duration',
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
            'status' => ArticleStatus::class,

            'is_breaking' => 'boolean',
            'is_featured' => 'boolean',
            'is_pokemon_go_featured' => 'boolean',

            'youtube_published_at' => 'datetime',

            'meta_keywords' => 'array',
            'robots_index' => 'boolean',
            'robots_follow' => 'boolean',

            'published_at' => 'datetime',
            'expires_at' => 'datetime',

            'reading_time' => 'integer',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope the query to published articles.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', ArticleStatus::Published)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where(function (Builder $query) {
                $query
                    ->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    /**
     * Scope the query to featured articles.
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope the query to breaking articles.
     */
    public function scopeBreaking(Builder $query): Builder
    {
        return $query->where('is_breaking', true);
    }

    /**
     * Scope the query to Pokémon GO featured articles.
     */
    public function scopePokemonGoFeatured(Builder $query): Builder
    {
        return $query->where('is_pokemon_go_featured', true);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the category that belongs to the article.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the user that created the article.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the hero image that belongs to the article.
     */
    public function heroImage(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'hero_asset_id');
    }

    /**
     * Get the daily view records for the article.
     */
    public function dailyViews(): HasMany
    {
        return $this->hasMany(ArticleDailyView::class);
    }

    /**
     * Get all non-deleted comments associated with the article.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get top-level comments, including soft-deleted comments,
     * so their replies can retain their thread context.
     */
    public function rootComments(): HasMany
    {
        return $this->hasMany(Comment::class)->withTrashed()->whereNull('parent_id');
    }

    /**
     * Get the sources associated with the article.
     */
    public function sources(): BelongsToMany
    {
        return $this->belongsToMany(Source::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Calculate the estimated reading time for the given content.
     */
    public static function calculateReadingTime(string $content): int
    {
        $text = strip_tags($content);

        $wordCount = str_word_count($text);

        return max(1, (int) ceil($wordCount / 200));
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
        return $this->excerpt;
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
        return $this->heroImage?->getFirstMediaUrl('asset', 'og-jpg');
    }
}