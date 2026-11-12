<div class="absolute top-3 right-3 z-10 px-3 py-2 text-xs uppercase font-display font-black text-white rounded-sm bg-[var(--color-primary)]">

    @if (filled($article->video_url))

        {{ __('general.video') }}

    @else

        {{ $article->category->name }}

    @endif

</div>