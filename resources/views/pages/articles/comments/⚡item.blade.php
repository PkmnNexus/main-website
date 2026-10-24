<?php

use App\Models\Comment;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component {
    public Comment $comment;

    public int $depth = 1;

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Get the comment author's avatar URL.
     */
    public function getAvatarUrl(): string
    {
        return $this->comment->user?->getFirstMediaUrl('user_avatar')
            ?: asset('images/default_avatar.png');
    }

    /**
     * Get the comment author's display name.
     */
    public function getDisplayName(): string
    {
        return $this->comment->user?->display_name ?? 'Former member';
    }

    /**
     * Get the author's flair, if available.
     */
    public function getFlair(): ?string
    {
        $flair = $this->comment->user?->getAttribute('flair');

        return is_string($flair) && filled($flair) ? $flair : null;
    }

    /**
     * Determine whether the comment has been soft deleted.
     */
    public function isDeleted(): bool
    {
        return $this->comment->trashed();
    }

    /*
    |--------------------------------------------------------------------------
    | Actions
    |--------------------------------------------------------------------------
    */

    /**
     * Start replying to this comment.
     */
    public function startReply(): void
    {
        $user = auth()->user();

        abort_unless(
            $user
            && $user->hasVerifiedEmail()
            && $user->is_active
            && ! $user->isSuspended(),
            403,
        );

        abort_unless(
            $this->depth < 3
            && $this->comment->canReceiveReplies(),
            403,
        );

        $this->dispatch(
            'reply-to-comment',
            commentId: $this->comment->id,
        );
    }

    /**
     * Refresh this comment when a reply is created.
     */
    #[On('comment-created')]
    public function refreshReplies(?int $parentId = null): void
    {
        if ($parentId !== $this->comment->id) {
            return;
        }

        $this->comment = Comment::withTrashed()
            ->with([
                'user',
                'replies.user',
                'replies.replies.user',
            ])
            ->findOrFail($this->comment->id);
    }
};

?>

<div id="comment-{{ $comment->id }}"
     @class([
        'space-y-3',
        'ml-5 border-l border-gray-200 pl-4 sm:ml-10 sm:pl-5' => $depth > 1,
     ])>

    <div class="flex items-start gap-3">

        <img src="{{ $this->getAvatarUrl() }}"
             alt="{{ $this->getDisplayName() }}'s avatar"
             width="44"
             height="44"
             loading="lazy"
             class="h-11 w-11 shrink-0 rounded-sm border border-gray-200 object-cover shadow-sm">

        <div class="min-w-0 flex-1 pt-1">

            @if ($this->isDeleted())

                <p class="text-sm italic text-gray-500">This comment has been removed.</p>

            @else

                <p class="whitespace-pre-line break-words text-sm leading-relaxed text-gray-800">{{ $comment->body }}</p>

            @endif

        </div>

    </div>

    <div class="flex flex-wrap items-center justify-between gap-3 rounded-sm border border-gray-200 px-3 py-2">

        <div class="min-w-0 flex-1">

            <div class="flex flex-wrap items-center gap-x-2 gap-y-1 text-xs sm:text-sm">

                <span class="font-bold text-[var(--color-secondary)]">{{ $this->getDisplayName() }}</span>

                @if ($this->getFlair())

                    <span class="rounded-sm bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-600">{{ $this->getFlair() }}</span>

                @endif

                <span class="text-gray-500">· {{ $comment->created_at->diffForHumans() }}</span>

            </div>

            @if ($comment->user && (filled($comment->user->location) || filled($comment->user->website) || $comment->user->social_links))

                <div class="comment-user-meta-secondary hidden md:flex flex-wrap items-center text-xs text-gray-500">

                    @if (filled($comment->user->location))

                        <span class="inline-flex items-center gap-1 mr-1">
                            <x-heroicon-o-map-pin class="h-3.5 w-3.5 shrink-0" />
                            <span>{{ $comment->user->location }}</span>
                            @if (filled($comment->user->website) || $comment->user->social_links)

                                <span class="mx-1 text-gray-400">·</span>

                            @endif
                        </span>

                    @endif

                    @if (filled($comment->user->website))

                        <a href="{{ $comment->user->website }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           aria-label="Visit website"
                           title="{{ $comment->user->website }}"
                           class="inline-flex items-center gap-1 mr-1 transition-colors duration-200 hover:text-[var(--color-primary)]">

                            <x-heroicon-o-globe-alt class="h-4 w-4 shrink-0" />

                            <span>{{ $comment->user->formatted_website }}</span>

                            @if ($comment->user->social_links)
                                <span class="ml-1 mr-1 text-gray-400">·</span>
                            @endif

                        </a>

                    @endif

                    @foreach ($comment->user->social_links as $link)

                        <a href="{{ $link['url'] }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           aria-label="{{ $link['platform'] }}"
                           title="{{ $link['platform'] }}"
                           class="inline-flex items-center gap-1 mr-3 transition-colors duration-200 hover:text-[var(--color-primary)] social">

                            <x-dynamic-component :component="$link['icon']" :size="16" />

                        </a>

                    @endforeach

                </div>

            @endif

        </div>

        <div class="flex shrink-0 items-center gap-3">

            @if (auth()->check()
                 && auth()->user()->hasVerifiedEmail()
                 && auth()->user()->is_active
                 && ! auth()->user()->isSuspended()
                 && $depth < 3
                 && ! $this->isDeleted())

                <button type="button" wire:click="startReply" class="cursor-pointer text-xs font-semibold text-[var(--color-secondary)] no-underline transition-colors duration-200 hover:text-[var(--color-primary)] hover:no-underline">Reply</button>

            @endif

            <span title="Report comment" aria-label="Report comment" class="inline-flex items-center gap-1 text-xs text-gray-500">

                <x-heroicon-o-flag class="h-4 w-4" />

                <span>Report comment</span>

            </span>

        </div>

    </div>

    @if ($depth < 3)

        @foreach ($comment->replies as $reply)

            <livewire:pages::articles.comments.item
                :comment="$reply"
                :depth="$depth + 1"
                :key="'comment-' . $reply->id"
            />

        @endforeach

    @endif

</div>