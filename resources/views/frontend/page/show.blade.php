<x-app :pageSeo="$pageSeo">

    <section class="max-w-lg md:max-w-3xl lg:max-w-4xl xl:max-w-6xl mx-auto px-6 xl:px-0 py-12"
             aria-labelledby="page"
             itemprop="articleBody">

            <x-pages.section-heading :title="$page->title" id="page" />

            <article class="prose prose-lg mx-auto mt-8 max-w-4xl" itemprop="articleBody" id="articleBody"> 
        
                {!! $page->content !!} 
            
            </article>

    </section>

</x-app>