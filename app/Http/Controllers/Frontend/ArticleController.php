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
use Spatie\Tags\Tag;

class ArticleController extends Controller
{
    public function index(): View
    {
        $pageSeo = Page::where('slug', 'articles')->firstOrFail();

        return view('frontend.article.index', compact('pageSeo'));
    }

    public function category(Category $category): View
    {
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
        $article = Article::query()
            ->where('slug', $slug)
            ->whereHas('category', function ($query) use ($category) {
                $query->where('slug', $category);
            })
            ->firstOrFail();

        $this->registerArticleView($article);

        $pageSeo = $article;

        return view('frontend.article.show', compact('article', 'pageSeo'));
    }

    /**
     * Count at most one view per article and session every 30 minutes.
     * Known bots and crawlers are excluded.
     */
    private function registerArticleView(Article $article): void
    {
        $userAgent = strtolower(request()->userAgent() ?? '');

        $isBot = (bool) preg_match(
            '/bot|crawler|spider|slurp|bingpreview|facebookexternalhit|monitoring/i',
            $userAgent
        );

        if ($isBot) {
            return;
        }

        $sessionId = request()->session()->getId();

        $viewKey = sprintf(
            'article-view:%s:%s',
            $article->getKey(),
            hash('sha256', $sessionId)
        );

        if (Cache::add($viewKey, true, now()->addMinutes(30))) {
            $article->registerView();
        }
    }
}