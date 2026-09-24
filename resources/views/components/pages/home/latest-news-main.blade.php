@foreach($articles as $index => $article)

    <x-pages.home.latest-news-article
        :article="$article"
        :position="$index + 1"
        class="group flex flex-col h-full shadow-lg rounded-b-lg transition duration-300 hover:shadow-2xl"
    >
        <figure class="overflow-hidden rounded-t-lg leading-none">

            <x-pages.responsive-picture
                :image="$article->heroImage?->responsiveImage()"
                :alt="$article->heroImage->alt ?: $article->title"
                sizes="(min-width: 1280px) 768px, (min-width: 1024px) 55vw, 100vw"
                class="w-full h-56 object-cover block transition duration-300 group-hover:scale-105 group-hover:shadow-xl"
                loading="lazy"
                fetchpriority="auto"
                decoding="async"
                itemprop="image"
            />

        </figure>

        <div class="bg-white rounded-b-lg p-8 flex flex-col flex-1">

            <div class="flex flex-col">

                <x-pages.article-date :date="$article->published_at" />

                <h3 class="text-xl mb-2 line-clamp-2 min-h-[3.5rem]" itemprop="headline">{{ $article->title }}</h3>

            </div>

            <p class="text-lg font-light !text-[var(--color-secondary)] leading-relaxed line-clamp-3 flex-1" itemprop="description">{{ $article->excerpt }}</p>

            <div class="mt-auto pt-4">

                <x-pages.tag-list :tags="$article->tags" class="flex flex-wrap p-0 m-0 list-none"/>
                
            </div>

        </div>

    </x-pages.home.latest-news-article>

@endforeach