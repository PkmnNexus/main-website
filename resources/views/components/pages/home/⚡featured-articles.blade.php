
<?php

use App\Models\Article;

use Illuminate\Support\Facades\Storage;

use Livewire\Component;

new class extends Component {

    public function with(): array
    {
        return [
            'articles' => Article::query()
                ->published()
                ->featured()
                ->with([
                    'category',
                    'heroImage.media',
                ])
                ->latest('published_at')
                ->take(7)
                ->get(),
        ];
    }
};
?>

@if($articles->isNotEmpty())

    @php
        $main = $articles->take(1)->first();
        $top = $articles->skip(1)->take(2);
        $bottom = $articles->skip(3)->take(4);
    @endphp

    <section
        class="lg:max-w-4xl xl:max-w-6xl mx-auto py-12"
        aria-labelledby="featured-heading"
        itemscope
        itemtype="https://schema.org/ItemList">

        <x-pages.section-heading title="Featured Articles" id="feature-heading"/>

        <x-pages.home.featured-swiper :articles="$articles"/>

        <div class="hidden px-6 xl:px-0 lg:grid grid-cols-3 gap-4">

            <x-pages.home.featured-main :articles="$main" :responsiveImage="$main->heroImage?->responsiveImage()" />

            <x-pages.home.featured-side :articles="$top"/>

        </div>

        <x-pages.home.featured-bottom :articles="$bottom" />

    </section>

@endif