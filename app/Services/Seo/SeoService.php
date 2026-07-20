<?php

namespace App\Services\Seo;

use App\Contracts\Seoable;

class SeoService
{
    public function for(Seoable $pageSeo): array
    {
        return [
            'title' => $this->title($pageSeo),
            'description' => $this->description($pageSeo),
            'keywords' => $this->keywords($pageSeo),

            'robots' => $this->robots($pageSeo),
            'canonical' => $this->canonical($pageSeo),

            'og_title' => $this->ogTitle($pageSeo),
            'og_description' => $this->ogDescription($pageSeo),
            'og_type' => $this->ogType($pageSeo),

            'published_time' => $pageSeo->created_at?->toIso8601String(),
            'modified_time' => $pageSeo->updated_at?->toIso8601String(),
            'image' => $this->image($pageSeo),
        ];
    }

    protected function firstFilled(...$values): ?string
    {
        foreach ($values as $value) {
            $value = trim((string) $value);

            if (filled($value)) {
                return $value;
            }
        }

        return null;
    }

    public function title(Seoable $pageSeo): string
    {
        return $this->firstFilled(
            $pageSeo->getSeoTitleSource(),
            $pageSeo->title,
            config('app.name'),
        );
    }

    public function description(Seoable $pageSeo): string
    {
        return $this->firstFilled(
            $pageSeo->getSeoDescriptionSource(),
            $pageSeo->getSeoExcerptSource(),
            $pageSeo->title,
            'Pokémon news, guides and updates',
        );
    }

    protected function keywords(Seoable $pageSeo): ?string
    {
        return $this->firstFilled(
            $pageSeo->getSeoKeywordsSource(),
            'keyword 1, keyword 2',
        );
    }

    protected function robots(Seoable $pageSeo): string
    {
        $index = $pageSeo->robots_index ? 'index' : 'noindex';
        $follow = $pageSeo->robots_follow ? 'follow' : 'nofollow';

        return "{$index}, {$follow}";
    }

    protected function canonical(Seoable $pageSeo): string
    {
        return $this->firstFilled(
            $pageSeo->getSeoCanonicalSource(),
            url()->current(),
        );
    }

    protected function ogTitle(Seoable $pageSeo): string
    {
        return $this->firstFilled(
            $pageSeo->getSeoOgTitleSource(),
            $pageSeo->title,
            config('app.name'),
        );
    }

    protected function ogDescription(Seoable $pageSeo): string
    {
        return $this->firstFilled(
            $pageSeo->getSeoOgDescriptionSource(),
            $pageSeo->getSeoDescriptionSource(),
            $pageSeo->getSeoExcerptSource(),
            $pageSeo->title,
            'Pokémon news, guides and updates',
        );
    }

    protected function ogType(Seoable $pageSeo): string
    {
        return $this->firstFilled(
            $pageSeo->getSeoOgTypeSource(),
            'website',
        );
    }

    protected function image(Seoable $pageSeo): string
    {
        return $this->firstFilled(
            $pageSeo->getSeoImageSource(),
            asset('images/og-default.jpg'),
        );
    }
}
