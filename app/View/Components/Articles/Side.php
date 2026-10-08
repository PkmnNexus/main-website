<?php

namespace App\View\Components\Articles;

use App\Models\Article;
use Illuminate\View\Component;
use Illuminate\View\View;

class Side extends Component
{
    public function __construct(
        public Article $article,
    ) {}

    public function render(): View
    {
        return view('components.articles.side');
    }
}