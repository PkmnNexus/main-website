<article class="bg-white rounded-lg shadow-md hover:shadow-xl transition duration-300 overflow-hidden group"
         itemscope
         itemtype="https://schema.org/Article">

    <div class="flex flex-col md:flex-row gap-6 p-6">

        <x-pages.links.article-link :article="$article" class="w-full md:w-64 flex-shrink-0">

            <x-pages.responsive-picture
                :article="$article"
                sizes="(min-width: 768px) 256px, 100vw"
                class="w-full h-60 md:h-full object-cover rounded-lg"
                loading="eager"
                fetchpriority="high"
            />

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