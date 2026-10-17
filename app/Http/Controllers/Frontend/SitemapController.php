<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Page;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = $this->getSitemapData()['urls'];

        return response()
            ->view('frontend.sitemap.xml', compact('urls'))
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function show(): View
    {
        $page = Page::query()
            ->where('slug', 'sitemap')
            ->where('is_active', true)
            ->firstOrFail();

        $pageSeo = $page;
        $sections = $this->getSitemapData()['sections'];

        return view('frontend.sitemap.index', compact('page', 'pageSeo', 'sections'));
    }

    private function getSitemapData(): array
    {
        $urls = [];
        $sections = [];

        $addUrl = function (string $section, string $url, string $title, $lastmod = null) use (&$urls, &$sections): void {
            $key = $this->normalizeUrl($url);

            if (isset($urls[$key])) {
                return;
            }

            $entry = [
                'loc' => $url,
                'title' => $title,
                'lastmod' => $lastmod?->toAtomString(),
            ];

            $urls[$key] = $entry;
            $sections[$section][] = $entry;
        };

        $addUrl('Main pages', route('home'), 'Home');

        if (Route::has('article.index')) {
            $addUrl('Articles', route('article.index'), 'All Articles');
        }

        if (Route::has('articles.videos')) {
            $addUrl('Videos', route('articles.videos'), 'All Videos');
        }

        $articles = Article::query()
            ->published()
            ->with(['category', 'tags'])
            ->get();

        $indexableArticles = collect();

        foreach ($articles as $article) {
            if ($article->robots_index === false) {
                continue;
            }

            if (filled($article->video_url)) {
                $articleUrl = route('article.video', ['slug' => $article->slug]);
                $section = 'Videos';
            } elseif ($article->category) {
                $articleUrl = route('article.show', [
                    'category' => $article->category->slug,
                    'slug' => $article->slug,
                ]);
                $section = 'Articles';
            } else {
                continue;
            }

            if (filled($article->canonical)
                && $this->normalizeUrl($article->canonical) !== $this->normalizeUrl($articleUrl)) {
                continue;
            }

            $addUrl($section, $articleUrl, $article->title, $article->updated_at);
            $indexableArticles->push($article);
        }

        $categories = $indexableArticles
            ->pluck('category')
            ->filter()
            ->unique('id');

        foreach ($categories as $category) {
            $addUrl('Categories', route('articles.category', ['category' => $category->slug]), $category->name);
        }

        $tags = $indexableArticles
            ->flatMap(fn ($article) => $article->tags)
            ->unique('id');

        foreach ($tags as $tag) {
            $addUrl('Tags', route('articles.tag', ['tag' => $tag->slug]), $tag->name);
        }

        $authorIds = $indexableArticles
            ->pluck('user_id')
            ->filter()
            ->unique();

        $authors = User::query()
            ->whereIn('id', $authorIds)
            ->get();

        foreach ($authors as $author) {
            if (filled($author->slug)) {
                $addUrl('Authors', route('articles.author', ['user' => $author->slug]), $author->name);
            }
        }

        $pages = Page::query()
            ->where('is_active', true)
            ->get();

        foreach ($pages as $page) {
            if ($page->robots_index === false) {
                continue;
            }

            $routeName = 'page.' . $page->slug;

            if (!Route::has($routeName)) {
                continue;
            }

            $pageUrl = route($routeName);

            if (filled($page->canonical)
                && $this->normalizeUrl($page->canonical) !== $this->normalizeUrl($pageUrl)) {
                continue;
            }

            $addUrl('Pages', $pageUrl, $page->title, $page->updated_at);
        }

        $urls = collect($urls)
            ->sortBy('loc')
            ->values()
            ->all();

        foreach ($sections as &$entries) {
            $entries = collect($entries)
                ->sortBy('title')
                ->values()
                ->all();
        }

        unset($entries);

        ksort($sections);

        return [
            'urls' => $urls,
            'sections' => $sections,
        ];
    }

    private function normalizeUrl(string $url): string
    {
        if (!str_starts_with($url, 'http://') && !str_starts_with($url, 'https://')) {
            $url = url('/' . ltrim($url, '/'));
        }

        return rtrim($url, '/') ?: '/';
    }
}