@if($article)

    <section class="max-w-lg md:max-w-3xl lg:max-w-4xl xl:max-w-6xl mx-auto px-6 xl:px-0 pt-12"
             aria-labelledby="breaking-news-heading"
             itemscope
             itemtype="https://schema.org/NewsArticle">

        <meta itemprop="datePublished" content="{{ $article->published_at->toIso8601String() }}">

        <div class="rounded-xl bg-gradient p-6 shadow-lg">

            <a href="{{ $article->video_url
                ? route('article.video', ['slug' => $article->slug])
                : route('article.show', ['category' => $article->category->slug, 'slug' => $article->slug]) }}"
               class="block text-white transition-opacity hover:opacity-90"
               itemprop="url">

                <div class="mb-3 flex items-center gap-2">

                    <span class="inline-block h-2 w-2 animate-pulse rounded-full bg-white"></span>

                    <span class="font-display text-sm font-black uppercase tracking-wider">Breaking News</span>

                </div>

                <h3 id="breaking-news-heading" class="font-display text-2xl font-bold md:text-3xl !text-white" itemprop="headline">{{ $article->title }}</h3>

                @if($article->excerpt)

                    <p class="mt-3 text-base font-medium leading-relaxed md:text-lg" itemprop="description">{{ $article->excerpt }}</p>

                @endif

            </a>

        </div>

    </section>

@endif