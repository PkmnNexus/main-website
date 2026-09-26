<?php

namespace App\View\Components\Pages\Links;

use App\Models\Article;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ArticleLink extends Component
{
    public function __construct(
        public Article $article,
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.pages.links.article-link');
    }
}