<?php

namespace App\View\Components\Pages\Home;

use App\Support\Media\ResponsiveImage;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FeaturedPicture extends Component
{
    public function __construct(
        public ResponsiveImage $image,
        public string $alt,
        public string $sizes,
        public string $class,
        public string $loading = 'lazy',
        public string $fetchpriority = 'auto',
        public ?string $itemprop = null,
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.pages.home.featured-picture');
    }
}