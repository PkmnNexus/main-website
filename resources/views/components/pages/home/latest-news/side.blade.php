<div class="news-side bg-[#FAFAFA] p-6 flex flex-col gap-3 md:col-span-2 xl:col-span-1">

    @foreach($articles as $index => $article)

        <x-pages.home.latest-news.news-article
            :article="$article"
            :position="$index + 3"
            class="shadow-lg rounded-lg">

            <div class="group flex items-center gap-4 p-3 bg-white text-[var(--color-secondary)] rounded-lg transition hover:bg-[var(--color-primary)]">

                <div class="w-20 h-20 overflow-hidden rounded-lg flex-shrink-0">

                    <x-pages.responsive-picture
                        :article="$article"
                        sizes="80px"
                        class="w-full h-full object-cover"
                        loading="eager"
                        fetchpriority="auto"
                    />

                </div>

                <h4 class="text-xl md:text-lg lg:text-default px-2 py-2 leading-tight self-start group-hover:!text-white"" itemprop="headline">{{ $article->title }}</h4>

            </div>

        </x-pages.home.latest-news-article>

    @endforeach

</div>