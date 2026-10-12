<?php

namespace App\View\Components\Pages;

use App\Models\Article;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class VideoEmbed extends Component
{
    public ?string $videoId;

    public ?string $embedUrl;

    public function __construct(
        public Article $article,
        public string $loading = 'lazy',
    ) {
        $this->videoId = $this->extractVideoId($article->video_url);

        $this->embedUrl = $this->videoId
            ? "https://www.youtube.com/embed/{$this->videoId}"
            : null;
    }

    /**
     * Extract and validate the ID from a supported YouTube URL.
     */
    protected function extractVideoId(?string $url): ?string
    {
        if (blank($url)) {
            return null;
        }

        $parts = parse_url(trim($url));

        if (! is_array($parts)) {
            return null;
        }

        $host = strtolower($parts['host'] ?? '');
        $path = trim($parts['path'] ?? '', '/');

        $videoId = null;

        if (in_array($host, [
            'youtube.com',
            'www.youtube.com',
            'm.youtube.com',
            'youtube-nocookie.com',
            'www.youtube-nocookie.com',
        ], true)) {
            if ($path === 'watch') {
                parse_str($parts['query'] ?? '', $query);

                $videoId = $query['v'] ?? null;
            } elseif (preg_match(
                '#^(?:embed|shorts|live)/([^/]+)$#',
                $path,
                $matches
            )) {
                $videoId = $matches[1];
            }
        } elseif (in_array($host, [
            'youtu.be',
            'www.youtu.be',
        ], true)) {
            $videoId = explode('/', $path)[0] ?? null;
        }

        return is_string($videoId)
            && preg_match('/^[A-Za-z0-9_-]{11}$/', $videoId)
                ? $videoId
                : null;
    }

    /**
     * Return the YouTube video thumbnail, or the article hero as fallback.
     */
    public function thumbnailUrl(): ?string
    {
        if ($this->videoId) {
            return "https://img.youtube.com/vi/{$this->videoId}/hqdefault.jpg";
        }

        return $this->article->heroImage?->getFirstMediaUrl('asset');
    }

    /**
     * Return the article publication date in ISO 8601 format.
     */
    public function uploadDate(): ?string
    {
        return $this->article->published_at?->toAtomString();
    }

    /**
     * Return the short description used on the video page.
     */
    public function description(): ?string
    {
        return $this->article->meta_description
            ?: $this->article->excerpt
            ?: null;
    }

    public function render(): View|Closure|string
    {
        return view('components.pages.video-embed');
    }
}