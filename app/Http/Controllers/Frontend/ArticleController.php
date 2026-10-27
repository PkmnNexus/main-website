<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

use App\Models\Article;
use App\Models\Category;
use App\Models\Page;
use App\Models\User;

use Carbon\CarbonInterval;

class ArticleController extends Controller
{
    public function index(): View
    {
        $pageSeo = Page::where('slug', 'articles')->firstOrFail();

        return view('frontend.article.index', compact('pageSeo'));
    }

    public function category(string $category): View
    {
        $locale = $this->contentLocale();

        $category = Category::query()
            ->where("slug->{$locale}", $category)
            ->firstOrFail();

        $pageSeo = Page::where('slug', 'articles')->firstOrFail();

        return view('frontend.article.index', compact('pageSeo', 'category'));
    }

    public function tag(string $tag): View
    {
        $pageSeo = Page::where('slug', 'articles')->firstOrFail();

        return view('frontend.article.index', [
            'pageSeo' => $pageSeo,
            'tag' => $tag,
        ]);
    }

    public function author(User $user): View
    {
        $pageSeo = Page::where('slug', 'articles')->firstOrFail();

        return view('frontend.article.index', compact('pageSeo', 'user'));
    }

    public function video(string $slug): View
    {
        $article = Article::query()
            ->where('slug', $slug)
            ->whereNotNull('video_url')
            ->firstOrFail();

        $this->registerArticleView($article);

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
        $pageSeo = Page::where('slug', 'articles')->firstOrFail();

        return view('frontend.article.index', compact('pageSeo'));
    }

    public function show(string $category, string $slug): View
    {
        $locale = $this->contentLocale();

        $article = Article::query()
            ->where('slug', $slug)
            ->whereHas('category', function ($query) use ($category, $locale) {
                $query->where("slug->{$locale}", $category);
            })
            ->firstOrFail();

        $pageSeo = $article;

        return view('frontend.article.show', compact('article', 'pageSeo'));
    }

    /**
     * Get the content locale, respecting the multilingual feature flag.
     */
    private function contentLocale(): string
    {
        if (! config('localization.enabled')) {
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