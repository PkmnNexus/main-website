<?php

namespace App\View\Components\Pages\Home;

use App\Models\Article;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ArticleListItem extends Component
{
    public function __construct(
        public Article $article,
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.pages.home.article-list-item');
    }
}