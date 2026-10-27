<?php

use App\Models\Article;
use Livewire\Component;

new class extends Component {
    public $articles;

    public function mount(): void
    {
        $locale = app()->getLocale();

        $this->articles = Article::query()
            ->published()
            ->whereHas('category', fn ($q) => $q->where('key', 'pokemon-go'))
            ->with([
                'category',
                'heroImage.media',
            ])
            ->latest('published_at')
            ->take(7)
            ->get();
    }
};
?>

<section class="mx-auto max-w-lg px-6 py-12 md:max-w-3xl lg:max-w-4xl xl:max-w-5xl xl:px-0"
            aria-labelledby="pokemon-go-heading"
            @if($articles->isNotEmpty())
                itemscope
                itemtype="https://schema.org/ItemList"
            @endif>

    @if($articles->isNotEmpty())

        <x-pages.section-heading title="Pokémon GO" id="pokemon-go-heading" />

        <x-pages.home.pokemon-go.main :article="$this->articles->first()" />

        <x-pages.home.pokemon-go.latest :articles="$this->articles->skip(1)->take(6)" />

    @else

        <div class="rounded px-4 py-3 text-sm font-display font-black uppercase text-white"
                style="background: linear-gradient(115deg, rgba(85, 65, 240, 1) 10%, rgba(71, 204, 189, 1) 100%);">
            {{ __('general.no_pokemon_go_articles') }}
        </div>

    @endif

</section>