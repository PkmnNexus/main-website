<?php

namespace App\View\Components\Pages;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SectionHeading extends Component
{
    public function __construct(
        public string $title,
        public string $id,
        public bool $srOnly = true,
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.pages.section-heading');
    }
}