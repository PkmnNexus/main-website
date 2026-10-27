@foreach($articles as $index => $article)

    <x-pages.home.latest-news.news-article
        :article="$article"
        :position="$index + 1"
        class="group flex flex-col h-full shadow-lg rounded-b-lg transition duration-300 hover:shadow-2xl">

        <figure class="relative overflow-hidden rounded-t-lg leading-none">

            <x-pages.responsive-picture
                :article="$article"
                sizes="(min-width: 1280px) 768px, (min-width: 1024px) 55vw, 100vw"
                class="w-full h-56 object-cover block transition duration-300 group-hover:scale-105 group-hover:shadow-xl"
                loading="eager"
                fetchpriority="auto"
            />

            <div class="absolute top-3 left-3 z-10 px-3 py-2 text-xs uppercase font-display font-black text-white rounded-sm bg-[var(--color-primary)]">

                <x-pages.article-date :date="$article->published_at" />

            </div>

            <div class="absolute top-3 right-3 z-10 px-3 py-2 text-xs uppercase font-display font-black text-white rounded-sm bg-[var(--color-primary)]">

                @if (filled($article->video_url))

                    {{ __('general.video') }}

                @else

                    {{ $article->category->name }}

                @endif

            </div>

            @if (filled($article->video_url))

                <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-10">

                    <div class="flex items-center justify-center w-14 h-14 rounded-full border-2 border-white bg-black/40 text-white transition duration-300 group-hover:bg-[var(--color-primary)] group-hover:scale-110">

                        <svg xmlns="http://www.w3.org/2000/svg" class="block w-6 h-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M8 5.14v13.72a.75.75 0 0 0 1.13.65l11-6.86a.75.75 0 0 0 0-1.3l-11-6.86A.75.75 0 0 0 8 5.14Z"/>
                        </svg>

                    </div>

                </div>

            @endif

        </figure>

        <div class="bg-white rounded-b-lg p-8 flex flex-col flex-1">

            <div class="flex flex-col">

                <h3 class="text-xl mb-2 line-clamp-2 min-h-[3.5rem]" itemprop="headline">{{ $article->title }}</h3>

            </div>

            <p class="text-lg font-light !text-[var(--color-secondary)] leading-relaxed line-clamp-3 flex-1" itemprop="description">{{ $article->excerpt }}</p>

            <div class="mt-auto pt-4">

                <x-pages.tag-list :tags="$article->tags" class="flex flex-wrap p-0 m-0 list-none" />

            </div>

        </div>

    </x-pages.home.latest-news.news-article>

@endforeach