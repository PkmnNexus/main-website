<div class="mt-3 border-t border-[#F0F0F0] pt-3">

    <div class="flex flex-wrap items-center gap-x-2 gap-y-1 font-display text-sm font-bold">

        <span itemprop="author"
              itemscope
              itemtype="https://schema.org/Person"
              class="text-primary">

            <a href="{{ localized_route('articles.author', ['user' => $article->user->slug]) }}" class="text-[var(--color-primary)] transition hover:text-[var(--color-secondary)]">

                {{ $article->user->display_name }}

            </a>

        </span>

        <span aria-hidden="true">-</span>

        <span class="text-secondary">

            {{ $article->reading_time }} {{ __('general.min_read') }}

        </span>

        <span aria-hidden="true">-</span>

        <span class="text-secondary">

            {{ __('general.published_at') }}

            <time itemprop="datePublished" datetime="{{ $article->published_at->toIso8601String() }}">{{ localized_date($article->published_at) }}</time>
        
        </span>

        @if ($article->updated_at->ne($article->created_at))

            <span aria-hidden="true">-</span>

            <span class="text-secondary">

                {{ __('general.edited_at') }}

                <time itemprop="dateModified" datetime="{{ $article->updated_at->toIso8601String() }}">{{ localized_date($article->updated_at) }}</time>

            </span>

        @endif

    </div>
    
</div>