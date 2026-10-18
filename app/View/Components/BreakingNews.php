<?php

namespace App\View\Components;

use App\Models\Article;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BreakingNews extends Component
{
    public function __construct(
        public int $visibleHours = 2,
    ) {}

    public function render(): View
    {
        $article = Article::query()
                            ->published()
                            ->where('is_breaking', true)
                            ->whereNotNull('published_at')
                            ->whereBetween('published_at', [
                                now()->subHours($this->visibleHours),
                                now(),
                            ])
                            ->with('category')
                            ->latest('published_at')
                            ->first();

        return view('components.breaking-news', [
            'article' => $article,
        ]);
    }
}