<x-app :pageSeo="$pageSeo">

    <article class="max-w-lg md:max-w-3xl lg:max-w-4xl xl:max-w-7xl mx-auto px-6 xl:px-0 py-12" 
             aria-labelledby="latest-video"
             itemscope
             itemtype="https://schema.org/Article">

        <x-articles.hero :article="$article" />

        <x-articles.breadcrumb :article="$article" />

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 mt-8">

            <div class="lg:col-span-3 rounded-xl bg-white shadow-md p-10">

                <x-articles.content :article="$article" />

                <x-articles.social-sharing :article="$article" />

                <x-articles.meta :article="$article" />

                <x-articles.tag-cloud :article="$article" />

            </div>

            <aside class="lg:col-span-1">

                <x-articles.side :article="$article" />

                <x-articles.categories />

            </aside>

        </div>

    </article>

    <x-articles.lightbox />

</x-app>