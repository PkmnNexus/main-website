
@if($article->sources->isNotEmpty())

    <section class="mt-6 border-t border-gray-200 pt-6" aria-labelledby="sources-heading"
             itemscope
             itemtype="https://schema.org/ItemList">

        <h2 id="sources-heading" class="font-display text-xl font-bold text-[var(--color-primary)]">{{ __('navigation.sources') }}</h2>

        <ul class="mt-4 !list-[square] leading-tight list-square space-y-2 pl-4 marker:text-[var(--color-primary)]">
    @foreach($article->sources as $source)

        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <meta itemprop="position" content="{{ $loop->iteration }}">

            <a href="{{ $source->url }}"
               target="_blank"
               rel="noopener noreferrer"
               class="text-sm font-medium text-[var(--color-secondary)] transition hover:text-[var(--color-primary)]"
               itemprop="item">
                <span itemprop="name">{{ $source->name }}</span>
            </a>
        </li>

    @endforeach
</ul>

    </section>

@endif
