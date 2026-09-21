
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
        itemtype="https://schema.org/ItemList"
    >

        <h2 id="featured-heading" class="sr-only">
            Featured Articles
        </h2>

        <div class="block lg:hidden">

            <div class="swiper relative px-4">

                <div class="swiper-wrapper">

                    @foreach($articles->take(5) as $article)
                        @php
                            $media = $article->heroImage?->getFirstMedia('asset');
                            $isPriority = $loop->first;

                            $responsiveImages = $media
                                ? (is_array($media->responsive_images)
                                    ? $media->responsive_images
                                    : json_decode($media->responsive_images, true))
                                : [];

                            $responsiveUrls = $responsiveImages['hero-webp']['urls'] ?? [];

                            $srcset = collect($responsiveUrls)
                                ->map(function ($filename) use ($media) {
                                    preg_match('/_(\d+)_\d+\.webp$/', $filename, $matches);

                                    if (! $media || ! isset($matches[1])) {
                                        return null;
                                    }

                                    $url = Storage::disk($media->disk)->url(
                                        $media->id . '/responsive-images/' . $filename
                                    );

                                    return $url . ' ' . $matches[1] . 'w';
                                })
                                ->filter()
                                ->implode(', ');
                        @endphp

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

                                        @if($media)
                                            <picture>
                                                @if($srcset)
                                                    <source
                                                        type="image/webp"
                                                        srcset="{{ $srcset }}"
                                                        sizes="100vw"
                                                    >
                                                @endif

                                                <img
                                                    src="{{ $media->getUrl('hero-webp') }}"
                                                    alt="{{ $article->heroImage->alt ?: $article->title }}"
                                                    width="1600"
                                                    height="900"
                                                    class="w-full h-80 md:h-100 object-cover group-hover:scale-105 transition duration-300"
                                                    loading="{{ $isPriority ? 'eager' : 'lazy' }}"
                                                    fetchpriority="{{ $isPriority ? 'high' : 'auto' }}"
                                                    decoding="async"
                                                    itemprop="image"
                                                >
                                            </picture>
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
                @php
                    $media = $main->heroImage?->getFirstMedia('asset');

                    $responsiveImages = $media
                        ? (is_array($media->responsive_images)
                            ? $media->responsive_images
                            : json_decode($media->responsive_images, true))
                        : [];

                    $responsiveUrls = $responsiveImages['hero-webp']['urls'] ?? [];

                    $srcset = collect($responsiveUrls)
                        ->map(function ($filename) use ($media) {
                            preg_match('/_(\d+)_\d+\.webp$/', $filename, $matches);

                            if (! $media || ! isset($matches[1])) {
                                return null;
                            }

                            $url = Storage::disk($media->disk)->url(
                                $media->id . '/responsive-images/' . $filename
                            );

                            return $url . ' ' . $matches[1] . 'w';
                        })
                        ->filter()
                        ->implode(', ');
                @endphp

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

                            @if($media)
                                <picture>
                                    @if($srcset)
                                        <source
                                            type="image/webp"
                                            srcset="{{ $srcset }}"
                                            sizes="(min-width: 1280px) 768px, (min-width: 1024px) 66vw, 100vw"
                                        >
                                    @endif

                                    <img
                                        src="{{ $media->getUrl('hero-webp') }}"
                                        alt="{{ $main->heroImage->alt ?: $main->title }}"
                                        width="1600"
                                        height="900"
                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                        loading="eager"
                                        fetchpriority="high"
                                        decoding="async"
                                        itemprop="image"
                                    >
                                </picture>
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
                    @php
                        $media = $article->heroImage?->getFirstMedia('asset');

                        $responsiveImages = $media
                            ? (is_array($media->responsive_images)
                                ? $media->responsive_images
                                : json_decode($media->responsive_images, true))
                            : [];

                        $responsiveUrls = $responsiveImages['hero-webp']['urls'] ?? [];

                        $srcset = collect($responsiveUrls)
                            ->map(function ($filename) use ($media) {
                                preg_match('/_(\d+)_\d+\.webp$/', $filename, $matches);

                                if (! $media || ! isset($matches[1])) {
                                    return null;
                                }

                                $url = Storage::disk($media->disk)->url(
                                    $media->id . '/responsive-images/' . $filename
                                );

                                return $url . ' ' . $matches[1] . 'w';
                            })
                            ->filter()
                            ->implode(', ');
                    @endphp

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

                                @if($media)
                                    <picture>
                                        @if($srcset)
                                            <source
                                                type="image/webp"
                                                srcset="{{ $srcset }}"
                                                sizes="(min-width: 1024px) 33vw, 100vw"
                                            >
                                        @endif

                                        <img
                                            src="{{ $media->getUrl('hero-webp') }}"
                                            alt="{{ $article->heroImage->alt ?: $article->title }}"
                                            width="1600"
                                            height="900"
                                            class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                            loading="lazy"
                                            fetchpriority="auto"
                                            decoding="async"
                                            itemprop="image"
                                        >
                                    </picture>
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
                @php
                    $media = $article->heroImage?->getFirstMedia('asset');

                    $responsiveImages = $media
                        ? (is_array($media->responsive_images)
                            ? $media->responsive_images
                            : json_decode($media->responsive_images, true))
                        : [];

                    $responsiveUrls = $responsiveImages['hero-webp']['urls'] ?? [];

                    $srcset = collect($responsiveUrls)
                        ->map(function ($filename) use ($media) {
                            preg_match('/_(\d+)_\d+\.webp$/', $filename, $matches);

                            if (! $media || ! isset($matches[1])) {
                                return null;
                            }

                            $url = Storage::disk($media->disk)->url(
                                $media->id . '/responsive-images/' . $filename
                            );

                            return $url . ' ' . $matches[1] . 'w';
                        })
                        ->filter()
                        ->implode(', ');
                @endphp

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

                            @if($media)
                                <picture>
                                    @if($srcset)
                                        <source
                                            type="image/webp"
                                            srcset="{{ $srcset }}"
                                            sizes="(min-width: 1024px) 25vw, 50vw"
                                        >
                                    @endif

                                    <img
                                        src="{{ $media->getUrl('hero-webp') }}"
                                        alt="{{ $article->heroImage->alt ?: $article->title }}"
                                        width="1600"
                                        height="900"
                                        class="w-full h-40 object-cover group-hover:scale-105 transition duration-300"
                                        loading="lazy"
                                        fetchpriority="auto"
                                        decoding="async"
                                        itemprop="image"
                                    >
                                </picture>
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