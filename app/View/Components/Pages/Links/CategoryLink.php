<?php

namespace App\View\Components\Pages\Links;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CategoryLink extends Component
{
    public function __construct(
        public Category $category,
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.pages.links.category-link');
    }
}