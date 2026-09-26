<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

use App\Models\Article;
use App\Models\Category;
use App\Models\Page;

use Spatie\Tags\Tag;

class ArticleController extends Controller
{
    public function index(): View
    {
        $pageSeo = Page::where('slug', 'articles')->firstOrFail();

        return view('frontend.article.index', compact('pageSeo'));
    }

    public function category(Category $category): View
    {
        $pageSeo = Page::where('slug', 'articles')->firstOrFail();

        return view('frontend.article.index', compact('pageSeo', 'category'));
    }

    public function tag(string $tag): View
    {
        $pageSeo = Page::where('slug', 'articles')->firstOrFail();

        return view('frontend.article.index', [
            'pageSeo' => $pageSeo,
            'tag' => $tag,
        ]);
    }

    public function show(string $category, string $slug): View
    {
        $article = Article::query()
            ->where('slug', $slug)
            ->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category);
            })
            ->firstOrFail();

        $pageSeo = $article;

        return view('frontend.article.show', compact('article', 'pageSeo'));
    }
}