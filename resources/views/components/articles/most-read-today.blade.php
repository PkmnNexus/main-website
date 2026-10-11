
@if($articles->isNotEmpty())

    <section class="news-side mb-6 flex flex-col gap-3 rounded-xl bg-[#FAFAFA] p-3 pt-6 shadow-md"
             aria-labelledby="most-read-today-heading"
             itemscope
             itemtype="https://schema.org/ItemList">

        <meta itemprop="name" content="Most read today">
        <meta itemprop="numberOfItems" content="{{ $articles->count() }}">

        <h2 id="most-read-today-heading" class="font-display text-xl font-bold text-[var(--color-primary)]">Most read today</h2>

        <div class="flex flex-col gap-3">

            @foreach($articles as $article)

                <article class="rounded-lg shadow-md"
                         itemprop="itemListElement"
                         itemscope
                         itemtype="https://schema.org/ListItem">

                    <meta itemprop="position" content="{{ $loop->iteration }}">

                    <div itemprop="item"
                         itemscope
                         itemtype="https://schema.org/Article">

                        <a href="{{ route('article.show', [
                                'category' => $article->category->slug,
                                'slug' => $article->slug,
                            ]) }}"
                           itemprop="url"
                           class="group flex items-center gap-1 rounded-lg bg-white p-3 text-[var(--color-secondary)] transition hover:bg-[var(--color-primary)] hover:shadow-lg">

                            <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-lg">

                                <x-pages.responsive-picture
                                    :article="$article"
                                    sizes="80px"
                                    class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                                    loading="lazy"
                                    fetchpriority="auto"
                                />

                            </div>

                            <h3 class="self-start px-2 py-2 font-display text-xl leading-tight transition-colors md:text-lg lg:text-sm group-hover:!text-white" itemprop="headline">{{ $article->title }}</h3>

                        </a>

                    </div>

                </article>

            @endforeach

        </div>

    </section>

@endif
