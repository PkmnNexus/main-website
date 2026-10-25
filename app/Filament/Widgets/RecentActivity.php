<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\Comment;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Collection;

class RecentActivity extends Widget
{
    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    */

    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = 'full';

    protected string $view = 'filament.widgets.recent-activity';

    /*
    |--------------------------------------------------------------------------
    | Activity
    |--------------------------------------------------------------------------
    */

    /**
     * Get the latest published articles.
     *
     * @return Collection<int, Article>
     */
    public function getRecentArticles(): Collection
    {
        return Article::query()
            ->published()
            ->with('category')
            ->latest('published_at')
            ->limit(5)
            ->get();
    }

    /**
     * Get the latest comments.
     *
     * @return Collection<int, Comment>
     */
    public function getRecentComments(): Collection
    {
        return Comment::query()
            ->with(['article', 'user'])
            ->latest()
            ->limit(5)
            ->get();
    }
}