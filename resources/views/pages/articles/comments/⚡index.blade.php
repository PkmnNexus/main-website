<?php

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Support\UserActivityRecorder;

new class extends Component {
    #[Locked]
    public Article $article;

    public string $body = '';

    public ?int $replyToId = null;

    /*
    |--------------------------------------------------------------------------
    | Lifecycle
    |--------------------------------------------------------------------------
    */

    /**
     * Initialize the comment section for the article.
     */
    public function mount(Article $article): void
    {
        abort_if(filled($article->video_url), 404);

        $this->article = $article;
    }

    /*
    |--------------------------------------------------------------------------
    | Computed Properties
    |--------------------------------------------------------------------------
    */

    /**
     * Get the number of non-deleted comments on the article.
     */
    #[Computed]
    public function commentCount(): int
    {
        return $this->article->comments()->count();
    }

    /**
     * Get the selected parent comment for a reply.
     */
    #[Computed]
    public function replyToComment(): ?Comment
    {
        if (! $this->replyToId) {
            return null;
        }

        return Comment::query()
            ->with('user')
            ->where('article_id', $this->article->id)
            ->find($this->replyToId);
    }

    /**
     * Get the top-level comments in chronological order.
     */
    #[Computed]
    public function rootComments(): Collection
    {
        return $this->article
            ->rootComments()
            ->with([
                'user',
                'replies.user',
                'replies.replies.user',
            ])
            ->orderBy('created_at')
            ->orderBy('id')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | Reply Handling
    |--------------------------------------------------------------------------
    */

    /**
     * Select a comment to reply to and focus the comment form.
     */
    #[On('reply-to-comment')]
    public function setReplyTo(int $commentId): void
    {
        $user = auth()->user();

        abort_unless(
            $user
            && $user->hasVerifiedEmail()
            && $user->is_active
            && ! $user->isSuspended(),
            403,
        );

        $comment = Comment::query()
            ->where('article_id', $this->article->id)
            ->findOrFail($commentId);

        abort_unless($comment->canReceiveReplies(), 403);

        $this->replyToId = $comment->id;

        unset($this->replyToComment);

        $this->resetValidation();

        $this->dispatch('focus-comment-form');
    }

    /**
     * Cancel the current reply.
     */
    public function cancelReply(): void
    {
        $this->replyToId = null;

        unset($this->replyToComment);

        $this->resetValidation();
    }

    /*
    |--------------------------------------------------------------------------
    | Actions
    |--------------------------------------------------------------------------
    */

    /**
     * Store a new comment or reply.
     */
    public function submit(): void
    {
        abort_if(filled($this->article->video_url), 404);

        $user = auth()->user();

        abort_unless(
            $user
            && $user->hasVerifiedEmail()
            && $user->is_active
            && ! $user->isSuspended(),
            403,
        );

        $validated = $this->validate([
            'body' => [
                'required',
                'string',
                'min:2',
                'max:2000',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if (
                        is_string($value)
                        && preg_match(
                            '~(?:https?://|www\.|(?:[a-z0-9-]+\.)+[a-z]{2,}(?:/\S*)?)~i',
                            $value,
                        )
                    ) {
                        $fail('Links are not allowed in comments.');
                    }
                },
            ],
        ]);

        $rateLimitKey = 'comment-post:'.$user->id.':'.request()->ip();

        if (RateLimiter::tooManyAttempts($rateLimitKey, 5)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);

            throw ValidationException::withMessages([
                'body' => "You are commenting too quickly. Please try again in {$seconds} seconds.",
            ]);
        }

        $parent = null;

        if ($this->replyToId !== null) {
            $parent = Comment::query()
                ->where('article_id', $this->article->id)
                ->findOrFail($this->replyToId);

            abort_unless($parent->canReceiveReplies(), 403);
        }

        $comment = Comment::create([
            'article_id' => $this->article->id,
            'user_id' => $user->id,
            'parent_id' => $parent?->id,
            'body' => $validated['body'],
        ]);

        RateLimiter::hit($rateLimitKey, 60);

        /*
         * Refresh the relevant comment thread.
         */
        $this->dispatch(
            'comment-created',
            parentId: $parent?->id,
            commentId: $comment->id,
        );

        /*
         * Return to the original comment after posting a reply.
         */
        $returnToCommentId = $parent?->id ?? $comment->id;

        $this->reset('body', 'replyToId');

        unset(
            $this->commentCount,
            $this->rootComments,
            $this->replyToComment,
        );

        $this->resetValidation();

        $this->dispatch(
            'comment-submitted',
            returnToCommentId: $returnToCommentId,
        );

        app(UserActivityRecorder::class)->record($user, 'Comment');
    }
};

?>

<section aria-labelledby="comments-heading"
         x-data
         x-on:focus-comment-form.window="
            setTimeout(() => {
                const textarea = document.getElementById('comment-body');

                if (textarea) {
                    textarea.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });

                    textarea.focus({ preventScroll: true });
                }
            }, 100)
         "
         x-on:comment-submitted.window="
            const targetId = $event.detail.returnToCommentId;

            setTimeout(() => {
                const target = document.getElementById('comment-' + targetId);

                target?.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }, 150)
         ">

    <h2 id="comments-heading" class="font-display text-2xl font-black text-[var(--color-secondary)]">Comments ({{ $this->commentCount }})</h2>

    @if (! auth()->check())

        <div class="mt-5 border-t border-gray-200 pt-5 text-sm text-gray-600">

            <p>You need to <a href="{{ route('login') }}" class="font-semibold text-[var(--color-secondary)] no-underline transition-colors duration-200 hover:text-[var(--color-primary)] hover:no-underline cursor-pointer">sign in</a>to comment.</p>

            @if (config('website.features.registration'))

                <p class="mt-1">Not a member yet? <a href="{{ route('register') }}" class="font-semibold text-[var(--color-secondary)] no-underline transition-colors duration-200 hover:text-[var(--color-primary)] hover:no-underline cursor-pointer">Register an account</a> to join the conversation.</p>

            @endif

        </div>

    @elseif (! auth()->user()->hasVerifiedEmail())

        <div class="mt-5 border-t border-gray-200 pt-5 text-sm text-gray-600">

            <p>Please verify your email address before commenting. <a href="{{ route('verification.notice') }}" class="font-semibold text-[var(--color-secondary)] no-underline transition-colors duration-200 hover:text-[var(--color-primary)] hover:no-underline cursor-pointer">Verify your email</a></p>

        </div>

    @elseif (! auth()->user()->is_active || auth()->user()->isSuspended())

        <div class="mt-5 border-t border-gray-200 pt-5 text-sm text-gray-600">

            Your account cannot currently post comments.

        </div>

    @else

        <form wire:submit="submit" class="mt-5 border-t border-gray-200 pt-5">

            @if ($replyToId)

                <p class="mb-2 text-sm text-gray-600">Replying to <span class="font-semibold text-[var(--color-secondary)]">{{ $this->replyToComment?->user?->display_name ?? 'this comment' }}</span>

                    <button type="button" wire:click="cancelReply" class="ml-2 cursor-pointer font-semibold text-[var(--color-secondary)] no-underline transition-colors duration-200 hover:text-[var(--color-primary)] hover:no-underline">Cancel</button>

                </p>

            @endif

            <label for="comment-body" class="mb-2 block text-sm font-bold">{{ $replyToId ? 'Your reply' : 'Write a comment' }}</label>

            <div x-data="{ remaining: 2000 }" x-init="remaining = 2000 - $refs.commentBody.value.length">

                <textarea id="comment-body"
                          x-ref="commentBody"
                          wire:model="body"
                          x-on:input="remaining = 2000 - $event.target.value.length"
                          rows="4"
                          maxlength="2000"
                          required
                          placeholder="Join the conversation..."
                          class="w-full rounded-sm border border-gray-200 px-3 py-2 text-sm focus:border-[var(--color-primary)] focus:outline-none"></textarea>

                <div class="mt-1 flex items-start justify-between gap-3">

                    <div class="min-w-0 flex-1">

                        @error('body')

                            <p class="text-sm text-red-600">{{ $message }}</p>

                        @enderror

                    </div>

                    <p class="shrink-0 text-xs" :class="remaining <= 100 ? 'font-semibold text-red-600' : 'text-gray-500'" aria-live="polite">

                        <span x-text="remaining"></span> characters remaining

                    </p>

                </div>

            </div>

            <div class="mt-3 flex justify-end">

                <button type="submit"
                        wire:loading.attr="disabled"
                        wire:target="submit"
                        class="cursor-pointer rounded-sm bg-gradient px-4 py-2 text-sm font-bold text-white transition-opacity hover:opacity-90 disabled:cursor-not-allowed disabled:opacity-50">

                    <span wire:loading.remove wire:target="submit">

                        {{ $replyToId ? 'Post Reply' : 'Post Comment' }}

                    </span>

                    <span wire:loading wire:target="submit">Posting...</span>

                </button>

            </div>

        </form>

    @endif

    <div class="mt-6 space-y-6">

        @forelse ($this->rootComments as $comment)

            <livewire:pages::articles.comments.item
                :comment="$comment"
                :depth="1"
                :key="'comment-' . $comment->id"
            />

        @empty

            <p class="py-6 text-sm text-gray-500">No comments yet. Be the first to join the conversation!</p>

        @endforelse

    </div>

</section>