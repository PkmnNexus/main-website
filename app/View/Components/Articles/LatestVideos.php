<?php

namespace App\View\Components\Articles;

use App\Models\Article;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LatestVideos extends Component
{
    public function __construct(
        public Article $article,
    ) {}

    public function render(): View
    {
        return view('components.articles.latest-videos', [
            'videos' => Article::query()
                ->published()
                ->whereNotNull('video_url')
                ->where('video_url', '!=', '')
                ->where('id', '!=', $this->article->id)
                ->latest('youtube_published_at')
                ->take(6)
                ->get(),
        ]);
    }
}