<article class="bg-white rounded-lg shadow-md hover:shadow-xl transition duration-300 overflow-hidden group"
         itemscope
         itemtype="https://schema.org/Article">

    <div class="flex flex-col md:flex-row gap-6 p-6">

        <x-pages.links.article-link :article="$article" class="w-full md:w-64 flex-shrink-0">

            <div class="relative h-60 md:h-full md:min-h-full">

                <x-pages.responsive-picture
                    :article="$article"
                    sizes="(min-width: 768px) 256px, 100vw"
                    class="w-full h-full object-cover rounded-lg"
                    loading="eager"
                    fetchpriority="high"
                />

                @if (filled($article->video_url))

                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">

                        <div class="flex items-center justify-center w-16 h-16 rounded-full border-2 border-white bg-black/40 text-white transition group-hover:bg-[var(--color-primary)]">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M8 5.14v13.72a.75.75 0 0 0 1.13.65l11-6.86a.75.75 0 0 0 0-1.3l-11-6.86A.75.75 0 0 0 8 5.14Z"/>
                            </svg>

                        </div>

                    </div>

                @endif

            </div>
            
        </x-pages.links.article-link>

        <div class="flex flex-col flex-1 min-w-0">

            <x-pages.links.article-link :article="$article" class="flex flex-col flex-1">

                <h3 class="text-xl lg:text-2xl text-[var(--color-secondary)] mb-2 transition group-hover:text-[var(--color-primary)]" itemprop="headline">{{ $article->title }}</h3>

                <p class="text-[var(--color-secondary)] mb-4 flex-1 font-light text-default lg:text-lg" itemprop="description">{{ $article->excerpt }}</p>

            </x-pages.links.article-link>

            <div class="border-t border-[#E5E7EB] pt-4 mt-auto">

                <div class="flex flex-wrap items-center gap-2">

                    <x-pages.links.category-link
                        :category="$article->category"
                        class="px-4 py-2 text-xs uppercase font-display bg-[var(--color-primary)] text-white rounded-sm transition hover:bg-[var(--color-secondary)]">

                        {{ $article->category->name }}
                        
                    </x-pages.links.category-link>
                    
                    <x-pages.article-date :date="$article->published_at" class="px-4 py-2 text-xs uppercase font-display bg-[var(--color-primary)] text-white rounded-sm" />

                </div>

            </div>

        </div>

    </div>

</article>