<x-app :pageSeo="$pageSeo">

    <livewire:pages.articles.index :category="$category ?? null" :tag="$tag ?? null" :user="$user ?? null" />

</x-app>