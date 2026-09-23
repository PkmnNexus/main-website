<?php

use App\Models\Article;
use Livewire\Component;

new class extends Component
{
    public function with(): array
    {
        $article = Article::query()
            ->published()
            ->whereNotNull('video_url')
            ->with([
                'category',
                'heroImage.media',
            ])
            ->latest('published_at')
            ->first();

        return [
            'article' => $article,
        ];
    }
};
?>
<section class="max-w-lg md:max-w-3xl lg:max-w-4xl xl:max-w-6xl mx-auto px-6 xl:px-0 pb-12">

    @if($article !== null)

        <x-pages.section-heading title="Latest Video" id="latest-video" :sr-only="false" />

        <div class="grid grid-cols-1 md:grid-cols-12 overflow-hidden rounded-xl shadow-lg">

            <div class="md:col-span-12 lg:col-span-7 xl:col-span-8">

                <x-pages.video-embed :article="$article" />

            </div>

            <div class="md:col-span-12 lg:col-span-5 xl:col-span-4 bg-[#FAFAFA] flex flex-col justify-between h-full p-6"
                 itemscope 
                 itemtype="https://schema.org/Article">

                <div>

                    <meta itemprop="headline" content="{{ $article->title }}">

                    <h2 class="!text-[var(--color-primary)] text-2xl">{{ $article->title }}</h2>

                    <p class="mt-4 text-lg font-light !text-[var(--color-secondary)] leading-relaxed" itemprop="description">{{ $article->excerpt }}</p>

                </div>

                <a  href="{{ collect(config('socialmedia'))->firstWhere('label', 'YouTube')['url'] }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    itemprop="url"
                    class="mt-6 inline-flex items-center justify-center bg-[var(--color-primary)] text-white font-display font-bold uppercase text-sm py-3 px-5 rounded-md hover:opacity-90 transition">
                    Watch more on YouTube
                </a>

            </div>

        </div>

    @else

        <div class="px-4 py-3 text-white text-sm font-display font-black uppercase rounded" style="background: linear-gradient(115deg, rgba(85, 65, 240, 1) 10%, rgba(71, 204, 189, 1) 100%);">
            There are currently no videos available.
        </div>

    @endif

</section>