<div class="mt-8 hidden md:flex flex-wrap items-center border-t border-[#F0F0F0] pt-4">

    <div class="mr-2 mb-2">

        <a href="{{ route('articles.author', $article->user) }}"
           class="px-4 py-2 text-xs font-bold uppercase bg-[var(--color-primary)] font-display text-white transition hover:bg-[var(--color-secondary)] rounded-sm inline-block">

            {{ $article->user->username }}
            
        </a>

    </div>

    <div class="mr-2 mb-2">

        <a href="{{ route('articles.category', $article->category) }}"
           class="px-4 py-2 text-xs font-bold uppercase bg-[var(--color-primary)] font-display text-white transition hover:bg-[var(--color-secondary)] rounded-sm inline-block">

            {{ $article->category->name }}

        </a>

    </div>

    <div class="ml-auto mr-0 mb-2">

        <time datetime="{{ $article->published_at->toIso8601String() }}" class="px-4 py-2 text-xs font-bold uppercase bg-[#F5F5F5] font-display text-[var(--color-secondary)] rounded-sm inline-block">
            
            {{ $article->published_at->format('F j, Y - h:i A') }}
        
        </time>

    </div>

</div>