<?php

namespace App\Support\Media;

use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ResponsiveImage
{
    public function __construct(
        protected Media $media,
        protected string $conversion = 'hero-webp',
    ) {}

    public function src(): string
    {
        return $this->media->getUrl($this->conversion);
    }

    public function srcset(): string
    {
        $responsiveImages = $this->media->responsive_images;

        if (! is_array($responsiveImages)) {
            $responsiveImages = json_decode(
                $responsiveImages ?? '{}',
                true
            );
        }

        $responsiveUrls = $responsiveImages[$this->conversion]['urls'] ?? [];

        return collect($responsiveUrls)
            ->map(function (string $filename): ?string {
                preg_match(
                    '/_(\d+)_\d+\.webp$/',
                    $filename,
                    $matches
                );

                if (! isset($matches[1])) {
                    return null;
                }

                $url = Storage::disk($this->media->disk)->url(
                    $this->media->id . '/responsive-images/' . $filename
                );

                return "{$url} {$matches[1]}w";
            })
            ->filter()
            ->implode(', ');
    }
}