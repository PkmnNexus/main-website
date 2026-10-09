@if($categories->isNotEmpty())

    <section class="rounded-xl bg-white p-6 shadow-md"
             aria-labelledby="categories-heading"
             itemscope
             itemtype="https://schema.org/ItemList">

        <meta itemprop="name" content="Explore categories">
        <meta itemprop="numberOfItems" content="{{ $categories->count() }}">

        <h2 id="categories-heading" class="font-display text-xl font-bold text-[var(--color-primary)]">Explore categories</h2>

        <nav aria-label="Article categories">

            <ul class="mt-4 divide-y divide-[#F0F0F0]">

                @foreach($categories as $category)

                    <li itemscope
                        itemprop="itemListElement"
                        itemtype="https://schema.org/ListItem">

                        <meta itemprop="position" content="{{ $loop->iteration }}">

                        <a href="{{ route('articles.category', $category) }}"
                           itemprop="item"
                           itemscope
                           itemtype="https://schema.org/Thing"
                           class="group flex items-center justify-between py-3 font-display text-sm font-bold text-[var(--color-secondary)] transition hover:text-[var(--color-primary)]">

                            <span itemprop="name">{{ $category->name }}</span>

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2"
                                 stroke-linecap="round"
                                 stroke-linejoin="round"
                                 class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1"
                                 aria-hidden="true">

                                <path d="m9 18 6-6-6-6"/>
                                
                            </svg>

                        </a>

                    </li>

                @endforeach

            </ul>

        </nav>

    </section>

@endif