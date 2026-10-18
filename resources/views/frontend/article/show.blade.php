<x-app :pageSeo="$pageSeo">

    <article class="max-w-lg md:max-w-3xl lg:max-w-4xl xl:max-w-7xl mx-auto px-6 xl:px-0 py-12" 
             aria-labelledby="latest-video"
             itemscope
             itemtype="https://schema.org/Article">

        <x-articles.hero :article="$article" />

        <x-articles.breadcrumb :article="$article" />

        <div class="grid grid-cols-1 xl:grid-cols-4 gap-8 mt-8">

            <div class="xl:col-span-3 rounded-xl bg-white shadow-md p-7 md:p-10">

                <x-articles.content :article="$article" />

                <x-articles.social-sharing :article="$article" />

                <x-articles.meta :article="$article" />

                <x-articles.tag-cloud :article="$article" />

                <x-articles.sources :article="$article" />

            </div>

            <aside class="xl:col-span-1">

                <x-articles.related-content :article="$article" />

                <div class="grid grid-cols-1 lg:grid-cols-2 lg:mt-4 xl:mt-0 xl:grid-cols-1 gap-2 lg:gap-6 xl:gap-0">

                    <x-articles.most-read-today />

                    <x-articles.categories />

                </div>

            </aside>

        </div>

    </article>

    <x-articles.lightbox />

</x-app>