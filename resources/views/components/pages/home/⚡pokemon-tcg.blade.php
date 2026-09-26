<?php

use App\Models\Article;
use Livewire\Component;

new class extends Component {
    public $latest;
    public $gallery;
    public $articles;

    public function mount(): void
    {
        $this->articles = Article::query()
            ->published()
            ->whereHas('category', fn ($query) => $query->where('slug', 'pokemon-tcg'))
            ->with([
                'category',
                'heroImage.media',
            ])
            ->latest('published_at')
            ->take(3)
            ->get();
    }
};
?>

<div class="bg-[#FAFAFA]">

    <section class="max-w-lg md:max-w-3xl lg:max-w-4xl xl:max-w-5xl mx-auto px-6 xl:px-0 py-12"
             aria-labelledby="tcg-heading"
             @if($articles->isNotEmpty())
                itemscope
                itemtype="https://schema.org/ItemList"
             @endif>

        @if($articles->isNotEmpty())

            <x-pages.section-heading title="Pokémon TCG" id="tcg-heading" />

            <x-pages.home.pokemon-tcg.main :article="$this->articles->first()" />

            <x-pages.home.pokemon-tcg.latest :articles="$this->articles->skip(1)->take(2)" />

        @else

            <div class="px-4 py-3 text-white text-sm font-display font-black uppercase rounded" style="background: linear-gradient(115deg, rgba(85, 65, 240, 1) 10%, rgba(71, 204, 189, 1) 100%);">
                There are currently no Pokémon TCG articles available.
            </div>

        @endif

    </section>

</div>