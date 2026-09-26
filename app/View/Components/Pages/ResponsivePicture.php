<?php

namespace App\View\Components\Pages;

use App\Models\Article;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ResponsivePicture extends Component
{
    public function __construct(
        public Article $article,
        public string $sizes,
        public string $class,
        public string $loading = 'lazy',
        public string $fetchpriority = 'auto',
    ) {}

    public function image()
    {
        return $this->article->heroImage?->responsiveImage();
    }

    public function alt(): string
    {
        return $this->article->heroImage?->alt ?: $this->article->title;
    }

    public function render(): View|Closure|string
    {
        return view('components.pages.responsive-picture');
    }
}