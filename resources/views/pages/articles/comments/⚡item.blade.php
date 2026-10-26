<?php

use App\Models\Comment;
use App\Models\CommentReport;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component {

    public Comment $comment;

    public int $depth = 1;

    public bool $showReportForm = false;

    public bool $reportSubmitted = false;

    public string $reportReason = '';

    public ?string $reportDetails = null;

    public string $reportFirstName = '';

    public string $reportLastName = '';

    public string $reportEmail = '';

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
        return $this->comment->user?->display_name ?? __('general.former_member');
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
     * Open the report form.
     */
    public function openReportForm(): void
    {
        abort_unless(! $this->isDeleted(), 403);

        abort_unless(
            ! auth()->user()
            || auth()->id() !== $this->comment->user_id,
            403,
        );

        $this->resetValidation();
        $this->reportSubmitted = false;
        $this->reportReason = '';
        $this->reportDetails = null;
        $this->reportFirstName = '';
        $this->reportLastName = '';
        $this->reportEmail = '';
        $this->showReportForm = true;
    }

    /**
     * Close the report form.
     */
    public function cancelReport(): void
    {
        $this->showReportForm = false;

        $this->reset(
            'reportReason',
            'reportDetails',
            'reportFirstName',
            'reportLastName',
            'reportEmail',
        );

        $this->resetValidation();
    }

    /**
     * Submit a report for this comment.
     */
    public function submitReport(): void
    {
        abort_unless(! $this->isDeleted(), 403);

        $user = auth()->user();

        abort_unless(
            ! $user || $user->id !== $this->comment->user_id,
            403,
        );

        $rules = [
            'reportReason' => [
                'required',
                'string',
                Rule::in([
                    'spam',
                    'harassment',
                    'hate_speech',
                    'inappropriate_content',
                    'other',
                ]),
            ],
            'reportDetails' => ['nullable', 'string', 'max:1000'],
        ];

        if (! $user) {
            $rules['reportFirstName'] = ['required', 'string', 'max:255'];
            $rules['reportLastName'] = ['required', 'string', 'max:255'];
            $rules['reportEmail'] = ['required', 'email', 'max:255'];
        }

        $validated = $this->validate($rules);

        CommentReport::create([
            'comment_id' => $this->comment->id,
            'user_id' => $user?->id,
            'first_name' => $user?->name ?? $validated['reportFirstName'] ?? null,
            'last_name' => $user?->surname ?? $validated['reportLastName'] ?? null,
            'email' => $user?->email ?? $validated['reportEmail'] ?? null,
            'reason' => $validated['reportReason'],
            'details' => $validated['reportDetails'] ?? null,
            'status' => CommentReport::STATUS_PENDING,
        ]);

        $this->showReportForm = false;
        $this->reportSubmitted = true;

        $this->reset(
            'reportReason',
            'reportDetails',
            'reportFirstName',
            'reportLastName',
            'reportEmail',
        );

        $this->resetValidation();
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
             alt="{{ __('general.comment_author_avatar', ['name' => $this->getDisplayName()]) }}"
             width="44"
             height="44"
             loading="lazy"
             class="h-11 w-11 shrink-0 rounded-sm border border-gray-200 object-cover shadow-sm">

        <div class="min-w-0 flex-1 pt-1">

            @if ($this->isDeleted())

                <p class="text-sm italic text-gray-500">{{ __('general.comment_removed') }}</p>

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
                           aria-label="{{ __('general.visit_website') }}"
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

                <button type="button" wire:click="startReply" class="cursor-pointer text-xs font-semibold text-[var(--color-secondary)] no-underline transition-colors duration-200 hover:text-[var(--color-primary)] hover:no-underline">{{ __('general.reply') }}</button>

            @endif

            @if (! $this->isDeleted() && (! auth()->check() || auth()->id() !== $comment->user_id))

                <button type="button"
                        wire:click="openReportForm"
                        class="inline-flex cursor-pointer items-center gap-1 text-xs text-gray-500 transition-colors duration-200 hover:text-[var(--color-primary)]"
                        aria-label="{{ __('general.report_comment') }}"
                        title="{{ __('general.report_comment') }}">

                    <x-heroicon-o-flag class="h-4 w-4" />

                    <span>{{ __('general.report_comment') }}</span>

                </button>

            @endif

        </div>

    </div>

    @if ($reportSubmitted)

        <div role="status" class="mt-4 rounded-sm bg-[var(--color-primary)] p-3 text-sm font-display font-bold text-white shadow-md">{{ __('general.comment_report_submitted') }}</div>

    @endif

    @if ($showReportForm)

        <form wire:submit="submitReport" class="space-y-4 rounded-sm border border-gray-200 bg-white p-4">

            <div>

                <h3 class="font-display text-base font-bold text-[var(--color-secondary)]">{{ __('general.report_comment') }}</h3>

                <p class="mt-1 text-sm text-gray-600">{{ __('general.comment_report_description') }}</p>

            </div>

            @guest

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                    <div>

                        <label for="reportFirstName-{{ $comment->id }}" class="mb-1 block text-sm font-bold">{{ __('general.first_name') }}</label>

                        <input id="reportFirstName-{{ $comment->id }}"
                               type="text"
                               wire:model="reportFirstName"
                               autocomplete="given-name"
                               required
                               maxlength="255"
                               class="w-full rounded-sm border border-gray-300 px-3 py-2 text-sm">

                        @error('reportFirstName')

                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>

                        @enderror

                    </div>

                    <div>

                        <label for="reportLastName-{{ $comment->id }}" class="mb-1 block text-sm font-bold">{{ __('general.last_name') }}</label>

                        <input id="reportLastName-{{ $comment->id }}"
                               type="text"
                               wire:model="reportLastName"
                               autocomplete="family-name"
                               required
                               maxlength="255"
                               class="w-full rounded-sm border border-gray-300 px-3 py-2 text-sm">

                        @error('reportLastName')

                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>

                        @enderror

                    </div>

                </div>

                <div>

                    <label for="reportEmail-{{ $comment->id }}" class="mb-1 block text-sm font-bold">{{ __('general.email_address') }}</label>

                    <input id="reportEmail-{{ $comment->id }}"
                           type="email"
                           wire:model="reportEmail"
                           autocomplete="email"
                           required
                           maxlength="255"
                           class="w-full rounded-sm border border-gray-300 px-3 py-2 text-sm">

                    @error('reportEmail')

                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>

                    @enderror

                </div>

            @endguest

            <div>

                <label for="reportReason-{{ $comment->id }}" class="mb-1 block text-sm font-bold">{{ __('general.reason_for_reporting') }}</label>

                <select id="reportReason-{{ $comment->id }}"
                        wire:model="reportReason"
                        required
                        class="w-full rounded-sm border border-gray-300 px-3 py-2 text-sm">

                    <option value="">{{ __('general.select_a_reason') }}</option>

                    <option value="spam">{{ __('general.report_reason_spam') }}</option>

                    <option value="harassment">{{ __('general.report_reason_harassment') }}</option>

                    <option value="hate_speech">{{ __('general.report_reason_hate_speech') }}</option>

                    <option value="inappropriate_content">{{ __('general.report_reason_inappropriate_content') }}</option>

                    <option value="other">{{ __('general.report_reason_other') }}</option>

                </select>

                @error('reportReason')

                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>

                @enderror

            </div>

            <div>

                <label for="reportDetails-{{ $comment->id }}" class="mb-1 block text-sm font-bold">{{ __('general.additional_details') }} <span class="font-normal text-gray-500">({{ __('general.optional') }})</span></label>

                <textarea id="reportDetails-{{ $comment->id }}"
                          wire:model="reportDetails"
                          rows="3"
                          maxlength="1000"
                          class="w-full rounded-sm border border-gray-300 px-3 py-2 text-sm"
                          placeholder="{{ __('general.report_details_placeholder') }}"></textarea>

                <p class="mt-1 text-xs text-gray-500">{{ __('general.maximum_characters', ['count' => 1000]) }}</p>

                @error('reportDetails')

                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>

                @enderror

            </div>

            <div class="flex flex-wrap items-center gap-3">

                <button type="submit"
                        wire:loading.attr="disabled"
                        wire:target="submitReport"
                        class="cursor-pointer rounded-sm bg-gradient px-4 py-2 text-sm font-bold text-white transition-opacity duration-200 disabled:opacity-50">

                    <span wire:loading.remove wire:target="submitReport">{{ __('general.submit_report') }}</span>

                    <span wire:loading wire:target="submitReport">{{ __('general.submitting') }}</span>

                </button>

                <button type="button"

                        wire:click="cancelReport"

                        class="cursor-pointer rounded-sm border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 transition-colors duration-200 hover:bg-gray-50">

                    {{ __('general.cancel') }}

                </button>

            </div>

        </form>

    @endif

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