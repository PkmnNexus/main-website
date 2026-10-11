@if($article->tags->isNotEmpty())

    <section class="mt-6" aria-labelledby="tag-cloud-heading"
             itemscope
             itemtype="https://schema.org/ItemList">

        <h2 id="tag-cloud-heading" class="font-display text-xl font-bold text-[var(--color-primary)]">Tags</h2>

        <div class="mt-4">

            <x-pages.tag-list :tags="$article->tags" />

        </div>

    </section>

@endif