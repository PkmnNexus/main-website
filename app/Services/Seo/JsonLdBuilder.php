<?php

namespace App\Services\Seo;

use App\Contracts\Seoable;
use App\Models\Article;
use App\Models\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class JsonLdBuilder
{
    public function for(Seoable $model): array
    {
        if ($model instanceof Page && $model->slug === 'home') {
            return $this->homepage($model);
        }

        $seoService = app(SeoService::class);

        $type = ucfirst(strtolower(trim((string) $model->getSeoSchemaType())));

        $base = [
            '@context' => 'https://schema.org',
            '@type' => $type,
            'name' => $seoService->title($model),
            'description' => $seoService->description($model),
            'url' => url()->current(),
        ];

        return match ($type) {
            'Article' => array_merge($base, [
                'author' => $this->author($model),
                'datePublished' => $model->created_at?->toIso8601String(),
                'dateModified' => $model->updated_at?->toIso8601String(),
            ]),

            'Webpage' => array_merge($base, [
                'mainEntityOfPage' => url()->current(),
            ]),

            default => $base,
        };
    }

    /**
     * Build the structured data graph for the homepage.
     */
    protected function homepage(Seoable $pageSeo): array
    {
        $seoService = app(SeoService::class);

        $siteUrl = url('/');
        $canonical = $seoService->for($pageSeo)['canonical'];

        $organizationId = rtrim($siteUrl, '/') . '/#organization';
        $websiteId = rtrim($siteUrl, '/') . '/#website';
        $webpageId = rtrim($canonical, '/') . '/#webpage';

        $sections = [
            'featured' => [
                'name' => 'Featured Articles',
                'articles' => Article::query()
                    ->published()
                    ->featured()
                    ->with(['category', 'heroImage.media', 'user'])
                    ->latest('published_at')
                    ->take(7)
                    ->get(),
            ],

            'headlines' => [
                'name' => 'Headlines',
                'articles' => $this->articlesByCategory('news', 6),
            ],

            'pokemon-tcg' => [
                'name' => 'Pokémon TCG',
                'articles' => $this->articlesByCategory('pokemon-tcg', 3),
            ],

            'deep-dive' => [
                'name' => 'Deep Dive',
                'articles' => $this->articlesByCategory('deep-dive', 1),
            ],

            'pokemon-go' => [
                'name' => 'Pokémon GO',
                'articles' => $this->articlesByCategory('pokemon-go', 7),
            ],

            'article-overview' => [
                'name' => 'Latest Articles',
                'articles' => Article::query()
                    ->published()
                    ->with(['category', 'heroImage.media', 'user'])
                    ->latest('published_at')
                    ->take(10)
                    ->get(),
            ],
        ];

        $graph = [
            [
                '@type' => 'Organization',
                '@id' => $organizationId,
                'name' => 'PkmnNexus',
                'url' => $siteUrl,
            ],
            [
                '@type' => 'WebSite',
                '@id' => $websiteId,
                'name' => 'PkmnNexus',
                'url' => $siteUrl,
                'publisher' => [
                    '@id' => $organizationId,
                ],
            ],
            [
                '@type' => 'WebPage',
                '@id' => $webpageId,
                'url' => $canonical,
                'name' => $seoService->title($pageSeo),
                'description' => $seoService->description($pageSeo),
                'isPartOf' => [
                    '@id' => $websiteId,
                ],
                'about' => [
                    '@id' => $organizationId,
                ],
            ],
        ];

        /*
         * Build one unique Article entity per article, even when it
         * appears in multiple homepage sections.
         */
        $allArticles = collect($sections)
            ->pluck('articles')
            ->flatten()
            ->unique('id')
            ->values();

        foreach ($allArticles as $article) {
            $graph[] = $this->articleSchema($article, $organizationId);
        }

        /*
         * Build a separate ItemList for every homepage section.
         */
        foreach ($sections as $slug => $section) {
            $listId = rtrim($canonical, '/') . '/#' . $slug;

            $items = $section['articles']
                ->values()
                ->map(function (Article $article, int $index): array {
                    return [
                        '@type' => 'ListItem',
                        'position' => $index + 1,
                        'item' => [
                            '@id' => $this->articleUrl($article) . '#article',
                        ],
                    ];
                })
                ->all();

            $graph[] = [
                '@type' => 'ItemList',
                '@id' => $listId,
                'name' => $section['name'],
                'numberOfItems' => count($items),
                'itemListElement' => $items,
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@graph' => $graph,
        ];
    }

    /**
     * Retrieve the latest published articles for a category.
     */
    protected function articlesByCategory(string $slug, int $limit): Collection
    {
        return Article::query()
            ->published()
            ->whereHas('category', fn (Builder $query) => $query->where('slug', $slug))
            ->with(['category', 'heroImage.media', 'user'])
            ->latest('published_at')
            ->take($limit)
            ->get();
    }

    /**
     * Generate the canonical article URL using the category and slug route parameters.
     */
    protected function articleUrl(Article $article): string
    {
        return route('article.show', [
            'category' => $article->category->slug,
            'slug' => $article->slug,
        ]);
    }

    /**
     * Build structured data for an individual article.
     */
    protected function articleSchema(Article $article, string $organizationId): array
    {
        $seoService = app(SeoService::class);

        $url = $this->articleUrl($article);

        $schema = [
            '@type' => 'Article',
            '@id' => $url . '#article',
            'headline' => $seoService->title($article),
            'url' => $url,
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $url,
            ],
            'publisher' => [
                '@id' => $organizationId,
            ],
        ];

        if ($article->user) {
            $schema['author'] = [
                '@type' => 'Person',
                'name' => $article->user->username,
            ];
        }

        $description = $seoService->description($article);

        if (filled($description)) {
            $schema['description'] = $description;
        }

        $image = $article->heroImage?->getFirstMediaUrl('asset', 'og-jpg');

        if (filled($image)) {
            $schema['image'] = $image;
        }

        if ($article->published_at) {
            $schema['datePublished'] = $article->published_at->toIso8601String();
        }

        if ($article->updated_at) {
            $schema['dateModified'] = $article->updated_at->toIso8601String();
        }

        return $schema;
    }

    /**
     * Get the default author for an article.
     */
    protected function author(Seoable $model): string
    {
        return config('app.name');
    }
}
