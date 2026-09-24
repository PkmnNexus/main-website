
<?php

use App\Models\Article;

use Livewire\Component;

new class extends Component {

    public function with(): array
    {
        $articles = Article::query()
            ->published()
            ->featured()
            ->with([
                'category',
                'heroImage.media',
            ])
            ->latest('published_at')
            ->take(7)
            ->get();

        return [
            'articles' => $articles,
            'main' => $articles->take(1)->first(),
            'top' => $articles->skip(1)->take(2),
            'bottom' => $articles->skip(3)->take(4),
        ];
    }
};
?>

<section
    class="lg:max-w-4xl xl:max-w-6xl mx-auto py-12"
    aria-labelledby="featured-heading"
    @if($articles->isNotEmpty())
        itemscope
        itemtype="https://schema.org/ItemList"
    @endif>

    <x-pages.section-heading title="Featured Articles" id="feature-heading" :sr-only="true" />

    @if($articles->isNotEmpty())

        <x-pages.home.featured-swiper :articles="$articles" />

        <div class="hidden px-6 xl:px-0 lg:grid grid-cols-3 gap-4">

            <x-pages.home.featured-main :articles="$main" :responsiveImage="$main->heroImage?->responsiveImage()" />

            <x-pages.home.featured-side :articles="$top" />

        </div>

        <x-pages.home.featured-bottom :articles="$bottom" />

    @else

        <div class="px-4 py-3 text-white text-sm font-display font-black uppercase rounded" style="background: linear-gradient(115deg, rgba(85, 65, 240, 1) 10%, rgba(71, 204, 189, 1) 100%);">
            There are currently no featured articles available.
        </div>

    @endif

</section>