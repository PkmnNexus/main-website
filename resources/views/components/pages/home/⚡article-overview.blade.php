<?php

use App\Models\Article;
use Livewire\Component;

new class extends Component {
    public string $variant = 'default';

    public function mount(string $variant = 'default'): void
    {
        $this->variant = $variant;
    }

    public function with(): array
    {
        return [
            'articles' => Article::query()
                ->published()
                ->latest('published_at')
                ->take(10)
                ->get(),
        ];
    }
};
?>
<div class="bg-[#FAFAFA]">

    <section class="max-w-lg md:max-w-3xl lg:max-w-4xl xl:max-w-5xl mx-auto px-6 xl:px-0 py-12 flex flex-col gap-6">

        <x-pages.section-heading title="Articles" id="article-heading" />

        @foreach($articles as $article)

            <x-pages.home.article-list-item :article="$article" />

        @endforeach

    </section>

</div>