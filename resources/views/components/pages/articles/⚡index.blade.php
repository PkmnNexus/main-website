<?php

use App\Models\Article;
use App\Models\Category;
use App\Models\User;

use Spatie\Tags\Tag;

use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {

    use WithPagination;

    public ?Category $category = null;
    public ?User $user = null;
    public ?string $tag = null;
    public bool $videosOnly = false;

    public function mount(?Category $category = null, ?User $user = null, ?string $tag = null): void
    {
        $this->category = $category;
        $this->user = $user;
        $this->tag = $tag;
        $this->videosOnly = request()->routeIs('articles.videos');
    }

    public function updatingPage()
    {
        $this->dispatch('scrollToTop');
    }

    public function with(): array
    {
        $title = $this->videosOnly ? 'Videos' : 'Articles';

        if ($this->category) {
            $title = 'Category: ' . $this->category->name;
        }

        if ($this->tag) {
            $title = 'Tag: ' . $this->tag;
        }

        if ($this->user) {
            $title = 'Author: ' . $this->user->username;
        }

        return [
            'articles' => Article::query()
                ->published()
                ->when(
                    $this->videosOnly,
                    fn ($query) => $query
                        ->whereNotNull('video_url')
                        ->where('video_url', '!=', '')
                )
                ->when(
                    $this->category,
                    fn ($query) => $query->where('category_id', $this->category->id)
                )
                ->when(
                    $this->user,
                    fn ($query) => $query->where('user_id', $this->user->id)
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

        <div wire:loading.class="opacity-50"
             wire:target="gotoPage,previousPage,nextPage"
             class="transition-opacity duration-300">

            <div id="articles"class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach($articles as $article)

                    <article class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden group flex flex-col h-full"
                            itemscope
                            itemtype="https://schema.org/Article">

                        <x-pages.links.article-link :article="$article" class="block">

                            <div class="relative overflow-hidden">

                                <x-pages.responsive-picture
                                    :article="$article"
                                    sizes="(min-width: 1280px) 768px, (min-width: 1024px) 55vw, 100vw"
                                    class="w-full h-56 object-cover transition duration-300 group-hover:scale-105"
                                    loading="eager"
                                    fetchpriority="high"
                                />

                                <div class="absolute top-3 left-3 z-10 px-3 py-2 text-xs uppercase font-display font-black text-white rounded-sm bg-[var(--color-primary)]">

                                    <x-pages.article-date :date="$article->published_at" />

                                </div>

                                <div class="absolute top-3 right-3 z-10 px-3 py-2 text-xs uppercase font-display font-black text-white rounded-sm bg-[var(--color-primary)]">

                                    @if (filled($article->video_url))

                                        {{ __('general.video') }}

                                    @else

                                        {{ $article->category->name }}

                                    @endif

                                </div>

                                @if (filled($article->video_url))

                                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">

                                        <div class="flex items-center justify-center w-16 h-16 rounded-full border-2 border-white bg-black/40 text-white transition group-hover:bg-[var(--color-primary)]">

                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                <path d="M8 5.14v13.72a.75.75 0 0 0 1.13.65l11-6.86a.75.75 0 0 0 0-1.3l-11-6.86A.75.75 0 0 0 8 5.14Z"/>
                                            </svg>

                                        </div>

                                    </div>

                                @endif

                            </div>

                            <div class="p-6">

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