<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class YouTubeService
{
    private const API_URL = 'https://www.googleapis.com/youtube/v3/videos';

    /**
     * Retrieve public metadata for a YouTube video.
     *
     * Returns null when the URL is invalid or the video is unavailable.
     * HTTP/API errors are allowed to bubble up to the caller.
     *
     * @return array{
     *     published_at: string|null,
     *     thumbnail_url: string|null,
     *     duration: string|null
     * }|null
     */
    public function fetchMetadata(string $url): ?array
    {
        $videoId = $this->extractVideoId($url);

        if (! $videoId) {
            return null;
        }

        $apiKey = config('services.youtube.api_key');

        if (blank($apiKey)) {
            throw new \RuntimeException(
                'The YouTube API key is not configured.'
            );
        }

        $response = Http::acceptJson()
            ->timeout(10)
            ->get(self::API_URL, [
                'part' => 'snippet,contentDetails',
                'id' => $videoId,
                'key' => $apiKey,
            ])
            ->throw();

        $video = $response->json('items.0');

        if (! is_array($video)) {
            return null;
        }

        $snippet = $video['snippet'] ?? [];
        $contentDetails = $video['contentDetails'] ?? [];
        $thumbnails = $snippet['thumbnails'] ?? [];

        // Prefer the highest-quality thumbnail available.
        $thumbnailUrl = collect([
            $thumbnails['maxres']['url'] ?? null,
            $thumbnails['standard']['url'] ?? null,
            $thumbnails['high']['url'] ?? null,
            $thumbnails['medium']['url'] ?? null,
            $thumbnails['default']['url'] ?? null,
        ])->first(fn ($thumbnail) => filled($thumbnail));

        return [
            'published_at' => $snippet['publishedAt'] ?? null,
            'thumbnail_url' => $thumbnailUrl,
            'duration' => $contentDetails['duration'] ?? null,
        ];
    }

    /**
     * Extract the 11-character video ID from a supported YouTube URL.
     */
    public function extractVideoId(string $url): ?string
    {
        $url = trim($url);

        if ($url === '') {
            return null;
        }

        // Also support URLs entered without a scheme.
        if (! preg_match('#^https?://#i', $url)) {
            $url = 'https://' . $url;
        }

        $parts = parse_url($url);

        if (! is_array($parts)) {
            return null;
        }

        $host = Str::lower($parts['host'] ?? '');
        $path = trim($parts['path'] ?? '', '/');
        $videoId = null;

        if (in_array($host, [
            'youtube.com',
            'www.youtube.com',
            'm.youtube.com',
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

        if (! is_string($videoId)) {
            return null;
        }

        return preg_match('/^[A-Za-z0-9_-]{11}$/', $videoId)
            ? $videoId
            : null;
    }
}