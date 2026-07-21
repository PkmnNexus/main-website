<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use Illuminate\View\View;

use App\Models\Page;
use App\Models\Category;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $pageSeo = Page::where('slug', 'tag')->firstOrFail();
        return view('frontend.category', [
            'pageSeo' => $pageSeo,
            'category' => $category
        ]);
    }
}
