<?php

namespace App\View\Components\Articles;

use App\Models\Article;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class VideoInformation extends Component
{
    public function __construct(
        public Article $article,
        public ?string $duration = null,
    ) {}

    public function render(): View
    {
        return view('components.articles.video-information');
    }
}