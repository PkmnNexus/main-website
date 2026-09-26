<?php

namespace App\Livewire\Pages\Home;

use App\Models\Article;
use Livewire\Component;

new class extends Component
{
    public $articles;
    public $main;
    public $side;

    public function mount(): void
    {
        $this->articles = Article::query()
             ->whereHas('category', fn ($q) => $q->where('slug', 'news'))
             ->published()
             ->latest('published_at')
             ->take(6)
             ->get();
    }
};
?>
<section class="max-w-lg md:max-w-3xl lg:max-w-4xl xl:max-w-6xl mx-auto px-6 xl:px-0 py-12"
         aria-labelledby="headlines"
         @if($articles->isNotEmpty())
            itemscope
            itemtype="https://schema.org/ItemList"
         @endif>

    @if($articles->isNotEmpty())

        <x-pages.section-heading title="Headlines" id="headlines" />

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 items-stretch">

            <x-pages.home.latest-news.main :articles="$this->articles->take(2)" />

            <x-pages.home.latest-news.side :articles="$this->side = $this->articles->skip(2)->take(5)" />

        </div>

    @else

        <div class="px-4 py-3 text-white text-sm font-display font-black uppercase rounded" style="background: linear-gradient(115deg, rgba(85, 65, 240, 1) 10%, rgba(71, 204, 189, 1) 100%);">
            There are currently no news articles available.
        </div>

    @endif

</section>