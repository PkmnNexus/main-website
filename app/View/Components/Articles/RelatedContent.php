<?php

namespace App\View\Components\Articles;

use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;
use Illuminate\View\View;

class RelatedContent extends Component
{
    public Collection $relatedArticles;

    public function __construct(
        public Article $article,
    ) {
        $this->relatedArticles = Article::query()
            ->published()
            ->where('category_id', $this->article->category_id)
            ->whereKeyNot($this->article->getKey())
            ->with(['category', 'heroImage.media'])
            ->latest('published_at')
            ->take(5)
            ->get();
    }

    public function render(): View
    {
        return view('components.articles.related-content');
    }
}