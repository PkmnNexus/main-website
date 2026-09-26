<?php

use App\Models\Article;
use Livewire\Component;

new class extends Component {
    public ?Article $article = null;

    public function mount(): void
    {
        $this->article = Article::query()
            ->published()
            ->whereHas('category', fn ($query) => $query->where('slug', 'deep-dive'))
            ->with([
                'category',
                'heroImage.media',
            ])
            ->latest('published_at')
            ->first();
    }
};
?>
@if($article)

    <section class="max-w-lg md:max-w-3xl lg:max-w-4xl xl:max-w-5xl mx-auto px-6 xl:px-0 py-12"
             aria-labelledby="deep-dive-heading"
             itemscope
             itemtype="https://schema.org/ItemList">

        <x-pages.section-heading title="Deep Dive" id="deep-dive-heading" />

        <article class="group relative overflow-hidden rounded-xl shadow-lg transition duration-300 hover:shadow-2xl"
                 itemscope
                 itemtype="https://schema.org/Article"
                 itemprop="itemListElement">

            <meta itemprop="position" content="1">

            <x-pages.links.article-link :article="$article" class="block cursor-pointer">

                <figure class="relative">

                    <x-pages.responsive-picture
                        :article="$article"
                        sizes="(min-width: 1280px) 1024px, (min-width: 768px) 768px, 100vw"
                        class="w-full h-[420px] object-cover transition duration-300 group-hover:scale-105"
                        loading="eager"
                        fetchpriority="auto"
                    />

                    <div class="absolute inset-y-0 right-0 w-full bg-gradient-to-l from-[var(--color-primary)]/100 via-[var(--color-primary)]/75 to-transparent"></div>

                    <figcaption class="absolute bottom-6 inset-0 flex items-end justify-end px-6 md:px-12 text-white z-10">

                        <div class="max-w-xl text-left">

                            <meta itemprop="headline" content="{{ $article->title }}">

                            <h2 class="text-2xl md:text-4xl !text-white">{{ $article->title }}</h2>

                            <p class="mt-4 mb-2 text-xl font-light opacity-90" itemprop="description">{{ $article->excerpt }}</p>

                            <x-pages.article-date :date="$article->published_at" class="text-sm font-bold text-white mb-2" />

                        </div>

                    </figcaption>

                </figure>

            </x-pages.links.article-link>

        </article>

    </section>

@endif