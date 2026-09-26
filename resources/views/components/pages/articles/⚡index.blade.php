<?php

use App\Models\Article;
use App\Models\Category;

use Spatie\Tags\Tag;

use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {

    use WithPagination;

    public ?Category $category = null;
    public ?string $tag = null;

    public function updatingPage()
    {
        $this->dispatch('scrollToTop');
    }

    public function with(): array
    {
        $title = 'Articles';

        if ($this->category) {
            $title = 'Category: ' . $this->category->name;
        }

        if ($this->tag) {
            $title = 'Tag: ' . $this->tag;
        }

        return [
            'articles' => Article::query()
                ->published()
                ->when(
                    $this->category,
                    fn ($query) => $query->where('category_id', $this->category->id)
                )
                ->when(
                    $this->tag,
                    function ($query) {
                        $tag = Tag::where('slug', $this->tag)->first();

                        if ($tag) {
                            $query->withAnyTags([$tag]);
                        }
                    }
                )
                ->latest('published_at')
                ->paginate(15),

            'title' => $title,
        ];
    }
};
?>
<section class="max-w-6xl mx-auto px-6 xl:px-0 py-12"
         aria-labelledby="article-heading"
         itemscope 
         itemtype="https://schema.org/ItemList">

    <x-pages.section-heading :title="$title" id="article-heading" />

    @if($articles->isNotEmpty())

        <div
            wire:loading.class="opacity-50"
            wire:target="gotoPage,previousPage,nextPage"
            class="transition-opacity duration-300"
        >

        <div id="articles"class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach($articles as $article)

                <article class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden group flex flex-col h-full"
                         itemscope
                         itemtype="https://schema.org/Article">

                    <x-pages.links.article-link :article="$article" class="block">

                        <x-pages.responsive-picture
                            :article="$article"
                            sizes="(min-width: 1280px) 768px, (min-width: 1024px) 55vw, 100vw"
                            class="w-full h-56 object-cover transition duration-300 group-hover:scale-105"
                            loading="eager"
                            fetchpriority="high"
                        />

                        <div class="p-6">

                            <x-pages.article-date :date="$article->published_at" class="text-sm text-[var(--color-primary)] mb-2 block" />

                            <h3 class="text-xl text-[var(--color-primary)] mb-2" itemprop="headline">{{ $article->title }}</h3>

                            <p class="text-[var(--color-secondary)] font-light line-clamp-3 mb-4 leading-7" itemprop="description">{{ $article->excerpt }}</p>

                        </div>

                    </x-pages.links.article-link>

                </article>

            @endforeach

        </div>

        </div>

        <div class="mt-10">
            {{ $articles->links() }}
        </div>

    @else

        <div class="px-4 py-3 text-white text-sm font-display font-black uppercase rounded" style="background: linear-gradient(115deg, rgba(85, 65, 240, 1) 10%, rgba(71, 204, 189, 1) 100%);">
            There are currently no articles available.
        </div>

    @endif

</section>