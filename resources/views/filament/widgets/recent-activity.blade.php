
<x-filament-widgets::widget>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">

        <x-filament::section>

            <x-slot name="heading">Recent publications</x-slot>

            <x-slot name="description">The latest published articles on PkmnNexus.</x-slot>

            @php
                $articles = $this->getRecentArticles();
            @endphp

            @forelse ($articles as $article)

                <div class="flex items-start justify-between gap-4 border-b border-gray-200 py-3 last:border-0 dark:border-white/10">

                    <div class="min-w-0">

                        <p class="text-sm font-medium text-gray-950 dark:text-white">{{ $article->title }}</p>

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $article->category?->name ?? 'Uncategorized' }}</p>

                    </div>

                    <time class="shrink-0 text-xs text-gray-500 dark:text-gray-400" datetime="{{ $article->published_at?->toIso8601String() }}">

                        {{ $article->published_at?->diffForHumans() }}

                    </time>

                </div>

            @empty

                <p class="py-4 text-sm text-gray-500 dark:text-gray-400">No published articles yet.</p>

            @endforelse

        </x-filament::section>

        <x-filament::section>

            <x-slot name="heading">Recent comments</x-slot>

            <x-slot name="description">The latest comments submitted by your community.</x-slot>

            @php
                $comments = $this->getRecentComments();
            @endphp

            @forelse ($comments as $comment)

                <div class="border-b border-gray-200 py-3 last:border-0 dark:border-white/10">

                    <div class="flex items-start justify-between gap-4">

                        <p class="text-sm font-medium text-gray-950 dark:text-white">{{ $comment->user?->name ?? 'Unknown user' }}</p>

                        <time class="shrink-0 text-xs text-gray-500 dark:text-gray-400" datetime="{{ $comment->created_at?->toIso8601String() }}">{{ $comment->created_at?->diffForHumans() }}</time>
                    
                    </div>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ \Illuminate\Support\Str::limit($comment->body, 140) }}</p>

                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Article: {{ $comment->article?->title ?? 'Article unavailable' }}</p>

                </div>

            @empty

                <p class="py-4 text-sm text-gray-500 dark:text-gray-400">No comments yet.</p>

            @endforelse

        </x-filament::section>
        
    </div>
    
</x-filament-widgets::widget>