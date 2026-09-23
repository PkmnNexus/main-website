<?php

namespace App\View\Components\Pages;

use App\Models\Article;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class VideoEmbed extends Component
{
    public ?string $embedUrl = null;

    public function __construct(
        public Article $article,
        public string $loading = 'lazy',
    ) {
        preg_match(
            '/(?:youtube\.com.*(?:\?|&)v=|youtu\.be\/)([^&]+)/',
            $this->article->video_url,
            $matches
        );

        $videoId = $matches[1] ?? null;

        $this->embedUrl = $videoId
            ? "https://www.youtube.com/embed/{$videoId}"
            : null;
    }

    public function thumbnailUrl(): ?string
    {
        return $this->article->heroImage?->getFirstMediaUrl('asset');
    }

    public function uploadDate(): ?string
    {
        return $this->article->published_at?->toAtomString();
    }

    public function render(): View|Closure|string
    {
        return view('components.pages.video-embed');
    }
}