<?php

use App\Models\Article;
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
        itemtype="https://schema.org/ItemList"
    >

        <h2 id="featured-heading" class="sr-only">
            Featured Articles
        </h2>

        <div class="block lg:hidden">

            <div class="swiper relative px-4">

                <div class="swiper-wrapper">

                    @foreach($articles->take(5) as $article)
                        <div class="swiper-slide" wire:key="featured-mobile-{{ $article->id }}">

                            <article
                                class="group"
                                itemscope
                                itemtype="https://schema.org/Article"
                                itemprop="itemListElement"
                            >

                                <a
                                    href="{{ route('article.show', ['category' => $article->category->slug, 'slug' => $article->slug]) }}"
                                    itemprop="url"
                                >

                                    <figure class="relative overflow-hidden rounded-lg">

                                        @if($article->heroImage)
                                            <img
                                                src="{{ $article->heroImage->getFirstMediaUrl('asset', 'hero') }}"
                                                alt="{{ $article->heroImage->alt ?: $article->title }}"
                                                class="w-full h-80 md:h-100 lg:h-64 object-cover group-hover:scale-105 transition duration-300"
                                                loading="lazy"
                                                itemprop="image"
                                            >
                                        @endif

                                        <div class="absolute inset-0 bg-gradient-to-t from-[var(--color-primary)]/90 to-transparent"></div>

                                        <figcaption class="absolute bottom-4 p-4 text-white">
                                            <h3 class="text-2xl !text-white" itemprop="headline">
                                                {{ $article->title }}
                                            </h3>
                                        </figcaption>

                                    </figure>

                                </a>

                            </article>

                        </div>
                    @endforeach

                </div>

                <div class="swiper-pagination !bottom-2"></div>

            </div>

        </div>

        <div class="hidden px-6 xl:px-0 lg:grid grid-cols-3 gap-4">

            @if($main)
                <article
                    class="md:col-span-2 group h-full"
                    itemscope
                    itemtype="https://schema.org/Article"
                    itemprop="itemListElement"
                >

                    <a
                        href="{{ route('article.show', ['category' => $main->category->slug, 'slug' => $main->slug]) }}"
                        class="block h-full"
                        itemprop="url"
                    >

                        <figure class="relative overflow-hidden rounded-lg h-full transition-all duration-300 group-hover:shadow-xl">

                            @if($main->heroImage)
                                <img
                                    src="{{ $main->heroImage->getFirstMediaUrl('asset', 'hero') }}"
                                    alt="{{ $main->heroImage->alt ?: $main->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                    itemprop="image"
                                >
                            @endif

                            <div class="absolute inset-0 bg-gradient-to-t from-[var(--color-primary)]/90 via-[var(--color-primary)]/40 to-transparent"></div>

                            <figcaption class="absolute bottom-0 right-10 p-6 text-white z-10">

                                <h3 class="text-3xl line-clamp-2 leading-8 !text-white" itemprop="headline">
                                    {{ $main->title }}
                                </h3>

                                <p class="mt-2 text-xl leading-6 font-light opacity-90" itemprop="description">
                                    {{ $main->excerpt }}
                                </p>

                            </figcaption>

                        </figure>

                    </a>

                </article>
            @endif

            <div class="grid grid-rows-2 gap-4 h-full">

                @foreach($top as $article)
                    <article
                        class="group h-full"
                        wire:key="featured-top-{{ $article->id }}"
                        itemscope
                        itemtype="https://schema.org/Article"
                        itemprop="itemListElement"
                    >

                        <a
                            href="{{ route('article.show', ['category' => $article->category->slug, 'slug' => $article->slug]) }}"
                            class="block h-full"
                            itemprop="url"
                        >

                            <figure class="relative overflow-hidden rounded-lg h-full transition-all duration-300 group-hover:shadow-xl">

                                @if($article->heroImage)
                                    <img
                                        src="{{ $article->heroImage->getFirstMediaUrl('asset', 'hero') }}"
                                        alt="{{ $article->heroImage->alt ?: $article->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                        itemprop="image"
                                    >
                                @endif

                                <div class="absolute inset-0 bg-gradient-to-t from-[var(--color-primary)]/90 via-[var(--color-primary)]/40 to-transparent"></div>

                                <figcaption class="absolute bottom-0 p-4 text-white z-10">

                                    <h4 class="text-xl line-clamp-2 !text-white" itemprop="headline">
                                        {{ $article->title }}
                                    </h4>

                                </figcaption>

                            </figure>

                        </a>

                    </article>
                @endforeach

            </div>

        </div>

        <div class="hidden px-6 xl:px-0 lg:grid grid-cols-4 gap-4 mt-4">

            @foreach($bottom as $article)
                <article
                    class="group"
                    wire:key="featured-bottom-{{ $article->id }}"
                    itemscope
                    itemtype="https://schema.org/Article"
                    itemprop="itemListElement"
                >

                    <a
                        href="{{ route('article.show', ['category' => $article->category->slug, 'slug' => $article->slug]) }}"
                        itemprop="url"
                    >

                        <figure class="relative overflow-hidden rounded-lg transition-all duration-300 group-hover:shadow-xl">

                            @if($article->heroImage)
                                <img
                                    src="{{ $article->heroImage->getFirstMediaUrl('asset', 'hero') }}"
                                    alt="{{ $article->heroImage->alt ?: $article->title }}"
                                    class="w-full h-40 object-cover group-hover:scale-105 transition duration-300"
                                    itemprop="image"
                                >
                            @endif

                            <div class="absolute inset-0 bg-gradient-to-t from-[var(--color-primary)]/90 via-[var(--color-primary)]/40 to-transparent"></div>

                            <figcaption class="absolute bottom-0 p-3 !text-white z-10">

                                <h4 class="!text-white" itemprop="headline">
                                    {{ $article->title }}
                                </h4>

                            </figcaption>

                        </figure>

                    </a>

                </article>
            @endforeach

        </div>

    </section>

@endif