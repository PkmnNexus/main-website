<?php

namespace App\View\Components\Pages;

use Carbon\CarbonInterface;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ArticleDate extends Component
{
    public function __construct(
        public ?CarbonInterface $date = null,
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.pages.article-date');
    }
}