<?php

namespace App\View\Components\Articles;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;
use Illuminate\View\View;

class Categories extends Component
{
    public Collection $categories;

    public function __construct()
    {
        $this->categories = Category::query()
            ->whereHas('articles', function ($query) {
                $query->published();
            })
            ->orderBy('name')
            ->get();
    }

    public function render(): View
    {
        return view('components.articles.categories');
    }
}