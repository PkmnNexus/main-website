<?php

namespace App\Models\Concerns;

trait HasSeo
{
    public function seoTitle(): string
    {
        return $this->meta_title ?? $this->title;
    }

    public function seoDescription(): string
    {
        return $this->meta_description ?? (property_exists($this, 'excerpt') ? $this->excerpt : '');
    }

    public function seoKeywords(): ?string
    {
        return $this->meta_keywords;
    }

    public function seoRobots(): ?string
    {
        return $this->robots;
    }

    public function seoCanonical(): ?string
    {
        return $this->canonical;
    }

    public function ogTitle(): string
    {
        return $this->og_title ?? $this->seoTitle();
    }

    public function ogDescription(): string
    {
        return $this->og_description ?? $this->seoDescription();
    }

    public function ogType(): string
    {
        return $this->og_type ?? 'website';
    }
}