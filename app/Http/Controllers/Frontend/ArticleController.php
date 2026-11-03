<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

use App\Models\Article;
use App\Models\Category;
use App\Models\Page;
use App\Models\User;

use Carbon\CarbonInterval;

class ArticleController extends Controller
{
    public function index(): View
    {
        $pageSeo = $this->getArticlesPage();

        return view('frontend.article.index', compact('pageSeo'));
    }

    public function category(string $category): View
    {
        $locale = $this->contentLocale();

        $category = Category::query()
            ->where("slug->{$locale}", $category)
            ->firstOrFail();

        $pageSeo = $this->getArticlesPage();

        return view('frontend.article.index', compact('pageSeo', 'category'));
    }

    public function tag(string $tag): View
    {
        $pageSeo = $this->getArticlesPage();

        return view('frontend.article.index', [
            'pageSeo' => $pageSeo,
            'tag' => $tag,
        ]);
    }

    public function author(User $user): View
    {
        $pageSeo = $this->getArticlesPage();

        return view('frontend.article.index', compact('pageSeo', 'user'));
    }

    public function video(string $slug): View
    {
        $locale = $this->contentLocale();

        $article = Article::query()
            ->where("slug->{$locale}", $slug)
            ->whereNotNull('video_url')
            ->firstOrFail();

        $pageSeo = $article;

        $description = $article->meta_description ?: $article->excerpt;

        $duration = filled($article->youtube_duration)
            ? CarbonInterval::create($article->youtube_duration)->cascade()->format('%H:%I:%S')
            : null;

        $duration = $duration ? ltrim($duration, '0:') : null;

        return view('frontend.article.video', compact('article', 'pageSeo', 'description', 'duration'));
    }

    public function videos(): View
    {
        $pageSeo = $this->getArticlesPage();

        return view('frontend.article.index', compact('pageSeo'));
    }

    public function show(string $category, string $slug): View
    {
        $locale = $this->contentLocale();

        $article = Article::query()
            ->where("slug->{$locale}", $slug)
            ->whereHas('category', function ($query) use ($category, $locale) {
                $query->where("slug->{$locale}", $category);
            })
            ->firstOrFail();

        $pageSeo = $article;

        return view('frontend.article.show', compact('article', 'pageSeo'));
    }

    /**
     * Get the articles CMS page.
     */
    private function getArticlesPage(): Page
    {
        return Page::query()
            ->where('key', 'articles')
            ->firstOrFail();
    }

    /**
     * Get the content locale, respecting the multilingual feature flag.
     */
    private function contentLocale(): string
    {
        if (! config('localization.enabled', false)) {
            return config('localization.default', config('app.locale', 'en'));
        }

        $locale = app()->getLocale();
        $locales = array_keys(config('localization.locales', []));

        if (in_array($locale, $locales, true)) {
            return $locale;
        }

        return config('localization.default', config('app.locale', 'en'));
    }
}