<?php

namespace App\View\Components\Pages\Home;

use App\Models\Article;
use App\Support\Media\ResponsiveImage;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LatestNewsMain extends Component
{
    public function __construct(
        public $articles,
    ) {}

    public function responsiveImage(Article $article): ?ResponsiveImage
    {
        return $article->heroImage?->responsiveImage('hero-webp');
    }

    public function render(): View|Closure|string
    {
        return view('components.pages.home.latest-news.main');
    }
}