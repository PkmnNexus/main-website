@props([
    'showHeading' => true,
])

@if($article->tags->isNotEmpty())

    <section class="mt-6 xl:mt-0 xl:pt-5" aria-labelledby="tag-cloud-heading"
             itemscope
             itemtype="https://schema.org/ItemList">

        @if($showHeading)

            <h2 id="tag-cloud-heading" class="font-display text-xl font-bold text-[var(--color-primary)]">Tags</h2>

        @endif

        <div class="mt-4">

            <x-pages.tag-list :tags="$article->tags" :showBorder="false" />

        </div>

    </section>

@endif