<?php

namespace App\View\Components\Articles;

use App\Models\Article;
use Illuminate\View\Component;
use Illuminate\View\View;

class Sources extends Component
{
    public function __construct(
        public Article $article,
        public bool $showHeading = true,
    ) {}

    public function render(): View
    {
        return view('components.articles.sources');
    }
}