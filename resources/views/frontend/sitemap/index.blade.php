<x-app :pageSeo="$pageSeo">

    <section class="max-w-lg md:max-w-3xl lg:max-w-4xl xl:max-w-6xl mx-auto px-6 xl:px-0 py-12"
             aria-labelledby="page"
             itemprop="articleBody">

        <x-pages.section-heading :title="$page->title" id="page" />

        <article class="prose prose-lg mx-auto mt-8 max-w-4xl" itemprop="articleBody" id="articleBody">

            <div class="not-prose mt-8 space-y-8">

                @foreach ($sections as $section => $entries)

                    <section>

                        <h2 class="text-xl font-display font-black text-gray-900 mb-4">{{ $section }}</h2>

                        <ul class="space-y-3">

                            @foreach ($entries as $entry)

                                <li class="{{ in_array($section, ['Articles', 'Videos']) && !in_array($entry['title'], ['All Articles', 'All Videos']) ? 'pl-6' : '' }}">

                                    <a href="{{ $entry['loc'] }}" class="text-gray-700 hover:text-[var(--color-primary)] transition-colors">{{ $entry['title'] }}</a>

                                </li>

                            @endforeach

                        </ul>

                    </section>

                @endforeach

            </div>

        </article>

    </section>

</x-app>