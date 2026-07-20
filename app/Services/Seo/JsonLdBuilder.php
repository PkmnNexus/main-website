<?php

namespace App\Services\Seo;

use App\Contracts\Seoable;

class JsonLdBuilder
{
    public function for(Seoable $model): array
    {
        $type = ucfirst(strtolower(trim((string) $model->getSeoSchemaType())));

        $base = [
            '@context' => 'https://schema.org',
            '@type' => $type,
            'name' => app(SeoService::class)->title($model),
            'description' => app(SeoService::class)->description($model),
            'url' => url()->current(),
        ];

        return match ($type) {
            'Article' => array_merge($base, [
                'author' => $this->author($model),
                'datePublished' => $model->created_at?->toIso8601String(),
                'dateModified' => $model->updated_at?->toIso8601String(),
            ]),

            'Webpage' => array_merge($base, [
                'mainEntityOfPage' => url()->current(),
            ]),

            default => $base,
        };
    }

    protected function author(Seoable $model): string
    {
        return config('app.name');
    }
}
