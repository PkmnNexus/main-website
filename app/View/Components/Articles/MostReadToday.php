<?php

namespace App\View\Components\Articles;

use App\Models\Article;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class MostReadToday extends Component
{
    public Collection $articles;

    public function __construct()
    {
        $today = now(config('app.timezone'))->toDateString();

        $this->articles = Article::query()
            ->published()
            ->join('article_daily_views', function ($join) use ($today) {
                $join->on('articles.id', '=', 'article_daily_views.article_id')
                    ->where('article_daily_views.view_date', '=', $today);
            })
            ->select('articles.*')
            ->with(['category', 'heroImage.media'])
            ->orderByDesc('article_daily_views.views')
            ->orderByDesc('articles.published_at')
            ->take(5)
            ->get();
    }

    public function render(): View
    {
        return view('components.articles.most-read-today');
    }
}
