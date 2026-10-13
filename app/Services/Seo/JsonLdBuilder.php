<?php

namespace App\Services\Seo;

use App\Contracts\Seoable;
use App\Models\Article;
use App\Models\Category;
use App\Models\Page;
use App\Models\User;
use App\View\Components\Pages\VideoEmbed;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Spatie\Tags\Tag;

class JsonLdBuilder
{
    /**
     * Build JSON-LD for a page or article.
     */
    public function for(Seoable $model): array
    {
        // Homepage.
        if ($model instanceof Page && $model->slug === 'home') {
            return $this->homepage($model);
        }

        // Articles overview and its filtered variants.
        if ($model instanceof Page && $model->slug === 'articles') {
            return $this->articleIndex($model);
        }

        // Individual articles and dedicated video pages.
        if ($model instanceof Article) {
            if (request()->routeIs('article.video')) {
                return $this->videoPage($model);
            }

            return $this->articlePage($model);
        }

        $seoService = app(SeoService::class);

        $type = ucfirst(
            strtolower(trim((string) $model->getSeoSchemaType()))
        );

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
     * Build JSON-LD for the homepage.
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

        // Collect all articles and avoid duplicate Article entities.
        $allArticles = collect($sections)
            ->pluck('articles')
            ->flatten()
            ->unique('id')
            ->values();

        foreach ($allArticles as $article) {
            $graph[] = $this->articleSchema($article, $organizationId);
        }

        // Create an ItemList for every homepage section.
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
     * Build JSON-LD for the articles overview.
     *
     * Supports the main overview, category, tag and author routes.
     * Uses the same page size and ordering as the Livewire component.
     */
    protected function articleIndex(Seoable $pageSeo): array
    {
        $seoService = app(SeoService::class);

        $request = request();
        $route = $request->route();
        $routeName = $route?->getName();

        $siteUrl = url('/');
        $organizationId = rtrim($siteUrl, '/') . '/#organization';
        $websiteId = rtrim($siteUrl, '/') . '/#website';

        $category = null;
        $user = null;
        $tagSlug = null;

        // Resolve the active filter from the current route.
        if ($routeName === 'articles.category') {
            $routeCategory = $route->parameter('category');

            if ($routeCategory instanceof Category) {
                $category = $routeCategory;
            }
        }

        if ($routeName === 'articles.author') {
            $routeUser = $route->parameter('user');

            if ($routeUser instanceof User) {
                $user = $routeUser;
            }
        }

        if ($routeName === 'articles.tag') {
            $tagSlug = (string) $route->parameter('tag');
        }

        $title = 'Articles';

        if ($category) {
            $title = 'Category: ' . $category->name;
        }

        if ($tagSlug !== null) {
            $title = 'Tag: ' . $tagSlug;
        }

        if ($user) {
            $title = 'Author: ' . $user->username;
        }

        /*
         * Match the filters, ordering and pagination used by
         * the Livewire articles overview.
         */
        $query = Article::query()
            ->published()
            ->when(
                $category,
                fn (Builder $query) => $query->where(
                    'category_id',
                    $category->id
                )
            )
            ->when(
                $user,
                fn (Builder $query) => $query->where(
                    'user_id',
                    $user->id
                )
            )
            ->when(
                $tagSlug !== null,
                function (Builder $query) use ($tagSlug): void {
                    $tag = Tag::where('slug', $tagSlug)->first();

                    if ($tag) {
                        $query->withAnyTags([$tag]);
                    }
                }
            )
            ->with(['category', 'heroImage.media', 'user'])
            ->latest('published_at');

        $currentPage = max(1, $request->integer('page', 1));

        $articles = $query->paginate(
            15,
            ['*'],
            'page',
            $currentPage
        );

        $pageUrl = $request->fullUrl();
        $collectionId = $request->url() . '#collectionpage';
        $listId = $request->url() . '#article-list';
        $breadcrumbId = $request->url() . '#breadcrumb';

        // Build breadcrumbs for the active overview.
        $breadcrumbs = [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => route('home'),
            ],
            [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => 'Articles',
                'item' => route('article.index'),
            ],
        ];

        if ($category) {
            $breadcrumbs[] = [
                '@type' => 'ListItem',
                'position' => count($breadcrumbs) + 1,
                'name' => $category->name,
                'item' => route('articles.category', [
                    'category' => $category->slug,
                ]),
            ];
        }

        if ($tagSlug !== null) {
            $breadcrumbs[] = [
                '@type' => 'ListItem',
                'position' => count($breadcrumbs) + 1,
                'name' => 'Tag: ' . $tagSlug,
                'item' => route('articles.tag', [
                    'tag' => $tagSlug,
                ]),
            ];
        }

        if ($user) {
            $breadcrumbs[] = [
                '@type' => 'ListItem',
                'position' => count($breadcrumbs) + 1,
                'name' => 'Author: ' . $user->username,
                'item' => route('articles.author', [
                    'user' => $user->slug,
                ]),
            ];
        }

        // Build the list from the 15 articles on the active page.
        $listItems = $articles
            ->values()
            ->map(function (Article $article, int $index) use ($articles): array {
                $position = ($articles->firstItem() ?? 1) + $index;
                $url = $this->articleUrl($article);

                return [
                    '@type' => 'ListItem',
                    'position' => $position,
                    'item' => [
                        '@type' => 'Article',
                        '@id' => $url . '#article',
                        'headline' => $article->title,
                        'url' => $url,
                    ],
                ];
            })
            ->all();

        return [
            '@context' => 'https://schema.org',
            '@graph' => [
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
                    '@type' => 'CollectionPage',
                    '@id' => $collectionId,
                    'url' => $pageUrl,
                    'name' => $title,
                    'isPartOf' => [
                        '@id' => $websiteId,
                    ],
                    'mainEntity' => [
                        '@id' => $listId,
                    ],
                    'breadcrumb' => [
                        '@id' => $breadcrumbId,
                    ],
                ],

                [
                    '@type' => 'ItemList',
                    '@id' => $listId,
                    'name' => $title,
                    'numberOfItems' => count($listItems),
                    'itemListOrder' => 'https://schema.org/ItemListOrderDescending',
                    'itemListElement' => $listItems,
                ],

                [
                    '@type' => 'BreadcrumbList',
                    '@id' => $breadcrumbId,
                    'itemListElement' => $breadcrumbs,
                ],
            ],
        ];
    }

    /**
     * Build JSON-LD for a dedicated video watch page.
     */
    protected function videoPage(Article $article): array
    {
        $seoService = app(SeoService::class);

        $siteUrl = url('/');
        $url = route('article.video', ['slug' => $article->slug]);

        $organizationId = rtrim($siteUrl, '/') . '/#organization';
        $websiteId = rtrim($siteUrl, '/') . '/#website';
        $webpageId = $url . '#webpage';
        $videoId = $url . '#video';
        $breadcrumbId = $url . '#breadcrumb';

        // Reuse the existing component's YouTube URL and thumbnail logic.
        $videoEmbed = new VideoEmbed($article, 'eager');

        $description = $videoEmbed->description()
            ?: $seoService->description($article);

        $videoObject = [
            '@type' => 'VideoObject',
            '@id' => $videoId,
            'name' => $seoService->title($article),
            'embedUrl' => $videoEmbed->embedUrl,
            'mainEntityOfPage' => [
                '@id' => $webpageId,
            ],
            'publisher' => [
                '@id' => $organizationId,
            ],
        ];

        if (filled($description)) {
            $videoObject['description'] = $description;
        }

        // Use YouTube's publication date, not the article's publication date.
        if ($article->youtube_published_at) {
            $videoObject['uploadDate'] = $article->youtube_published_at
                ->toIso8601String();
        }

        // YouTube returns duration in ISO 8601 format.
        if (filled($article->youtube_duration)) {
            $videoObject['duration'] = $article->youtube_duration;
        }

        // Prefer the stored YouTube thumbnail, with the existing fallback.
        $thumbnailUrl = $article->youtube_thumbnail_url
            ?: $videoEmbed->thumbnailUrl();

        if (filled($thumbnailUrl)) {
            $videoObject['thumbnailUrl'] = [$thumbnailUrl];
        }

        return [
            '@context' => 'https://schema.org',
            '@graph' => [
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
                    'url' => $url,
                    'name' => $seoService->title($article),
                    'description' => $description,
                    'isPartOf' => [
                        '@id' => $websiteId,
                    ],
                    'mainEntity' => [
                        '@id' => $videoId,
                    ],
                    'breadcrumb' => [
                        '@id' => $breadcrumbId,
                    ],
                ],

                $videoObject,

                [
                    '@type' => 'BreadcrumbList',
                    '@id' => $breadcrumbId,
                    'itemListElement' => [
                        [
                            '@type' => 'ListItem',
                            'position' => 1,
                            'name' => 'Home',
                            'item' => route('home'),
                        ],
                        [
                            '@type' => 'ListItem',
                            'position' => 2,
                            'name' => 'Articles',
                            'item' => route('article.index'),
                        ],
                        [
                            '@type' => 'ListItem',
                            'position' => 3,
                            'name' => $seoService->title($article),
                            'item' => $url,
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Build JSON-LD for the currently selected article page.
     */
    protected function articlePage(Article $article): array
    {
        $seoService = app(SeoService::class);

        $siteUrl = url('/');
        $url = $this->articleUrl($article);

        $organizationId = rtrim($siteUrl, '/') . '/#organization';
        $websiteId = rtrim($siteUrl, '/') . '/#website';

        $articleSchema = $this->articleSchema(
            $article,
            $organizationId
        );

        $categoryUrl = route('articles.category', [
            'category' => $article->category->slug,
        ]);

        $breadcrumbId = $url . '#breadcrumb';

        return [
            '@context' => 'https://schema.org',
            '@graph' => [
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
                    '@id' => $url,
                    'url' => $url,
                    'name' => $seoService->title($article),
                    'description' => $seoService->description($article),
                    'isPartOf' => [
                        '@id' => $websiteId,
                    ],
                    'mainEntity' => [
                        '@id' => $url . '#article',
                    ],
                    'breadcrumb' => [
                        '@id' => $breadcrumbId,
                    ],
                ],

                $articleSchema,

                [
                    '@type' => 'BreadcrumbList',
                    '@id' => $breadcrumbId,
                    'itemListElement' => [
                        [
                            '@type' => 'ListItem',
                            'position' => 1,
                            'name' => 'Home',
                            'item' => route('home'),
                        ],
                        [
                            '@type' => 'ListItem',
                            'position' => 2,
                            'name' => $article->category->name,
                            'item' => $categoryUrl,
                        ],
                        [
                            '@type' => 'ListItem',
                            'position' => 3,
                            'name' => $seoService->title($article),
                            'item' => $url,
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Retrieve the latest published articles in a category.
     */
    protected function articlesByCategory(
        string $slug,
        int $limit
    ): Collection {
        return Article::query()
            ->published()
            ->whereHas(
                'category',
                fn (Builder $query) => $query->where('slug', $slug)
            )
            ->with(['category', 'heroImage.media', 'user'])
            ->latest('published_at')
            ->take($limit)
            ->get();
    }

    /**
     * Generate the canonical article URL.
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
    protected function articleSchema(
        Article $article,
        string $organizationId
    ): array {
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

        $description = $seoService->description($article);

        if (filled($description)) {
            $schema['description'] = $description;
        }

        $image = $article->heroImage?->getFirstMediaUrl(
            'asset',
            'og-jpg'
        );

        if (filled($image)) {
            $schema['image'] = $image;
        }

        if ($article->published_at) {
            $schema['datePublished'] = $article->published_at
                ->toIso8601String();
        }

        if ($article->updated_at) {
            $schema['dateModified'] = $article->updated_at
                ->toIso8601String();
        }

        if ($article->user) {
            $schema['author'] = [
                '@type' => 'Person',
                'name' => $article->user->name,
            ];
        }

        return $schema;
    }

    /**
     * Return a fallback author name for generic Article schemas.
     */
    protected function author(Seoable $model): string
    {
        return config('app.name');
    }
}