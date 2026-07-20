<?php

namespace App\View\Components;

use App\Contracts\Seoable;
use App\Services\Seo\JsonLdBuilder;
use App\Services\Seo\SeoService;
use Illuminate\View\Component;

class SeoHead extends Component
{
    public ?array $seo = null;

    public ?array $jsonLd = null;

    public function __construct(public ?Seoable $pageSeo = null)
    {
        if ($pageSeo) {
            $this->seo = app(SeoService::class)->for($pageSeo);
            $this->jsonLd = app(JsonLdBuilder::class)->for($pageSeo);
        }
    }

    public function render()
    {
        return view('components.seo.seo-head');
    }
}
