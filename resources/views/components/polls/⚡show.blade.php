<?php

use App\Models\Poll;
use App\Models\PollVote;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Locked;
use Livewire\Component;

new class extends Component
{
    public ?Poll $poll = null;

    public bool $hasVoted = false;

    public bool $showResults = false;

    public bool $justVoted = false;

    #[Locked]
    public ?string $voterHash = null;

    /*
    |--------------------------------------------------------------------------
    | Lifecycle
    |--------------------------------------------------------------------------
    */

    public function mount(): void
    {
        $this->poll = Poll::query()
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', now());
            })
            ->latest()
            ->with('options')
            ->first();

        if (! $this->poll) {
            return;
        }

        $this->getVoterHash(true);

        $existingVote = $this->existingVote();

        if (auth()->check() && $existingVote && ! $existingVote->voter_hash) {
            $existingVote->update([
                'voter_hash' => $this->getVoterHash(),
            ]);
        }

        $this->hasVoted = $existingVote !== null;

        $this->showResults = $this->hasVoted
            || ! $this->poll->isOpen()
            || $this->poll->show_results_before_vote;
    }

    /*
    |--------------------------------------------------------------------------
    | Voting
    |--------------------------------------------------------------------------
    */

    public function vote(int $optionId): void
    {
        if (! $this->poll || ! $this->poll->isOpen()) {
            throw ValidationException::withMessages([
                'vote' => __('general.poll_closed'),
            ]);
        }

        if ($this->existingVote()) {
            $this->hasVoted = true;
            $this->showResults = true;

            return;
        }

        $option = $this->poll->options()
            ->find($optionId);

        if (! $option) {
            throw ValidationException::withMessages([
                'vote' => __('general.poll_invalid_option'),
            ]);
        }

        $userId = auth()->id();

        $voterHash = $this->getVoterHash(true);

        try {
            $voteCreated = DB::transaction(function () use (
                $optionId,
                $userId,
                $voterHash,
            ) {
                $poll = Poll::query()
                    ->whereKey($this->poll->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if (! $poll->isOpen()) {
                    throw ValidationException::withMessages([
                        'vote' => __('general.poll_closed'),
                    ]);
                }

                if (! $poll->options()->whereKey($optionId)->exists()) {
                    throw ValidationException::withMessages([
                        'vote' => __('general.poll_invalid_option'),
                    ]);
                }

                $existing = $poll->votes()
                    ->where(function ($query) use ($userId, $voterHash) {
                        $query->where('voter_hash', $voterHash);

                        if ($userId !== null) {
                            $query->orWhere('user_id', $userId);
                        }
                    })
                    ->exists();

                if ($existing) {
                    return false;
                }

                PollVote::create([
                    'poll_id' => $poll->id,
                    'poll_option_id' => $optionId,
                    'user_id' => $userId,
                    'voter_hash' => $voterHash,
                ]);

                return true;
            });
        } catch (QueryException $exception) {
            if (! $this->existingVote()) {
                throw $exception;
            }

            $voteCreated = false;
        }

        $this->hasVoted = $this->existingVote() !== null;
        $this->showResults = $this->hasVoted;
        $this->justVoted = $voteCreated && $this->hasVoted;

        if ($this->justVoted) {
            $this->dispatch('poll-voted', pollId: $this->poll->id);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Visitor Identification
    |--------------------------------------------------------------------------
    */

    protected function getVoterHash(bool $persistCookie = false): string
    {
        if ($this->voterHash !== null) {
            return $this->voterHash;
        }

        $voterId = request()->cookie('poll_voter_id');

        if (! is_string($voterId) || $voterId === '') {
            $voterId = Str::random(64);
        }

        if ($persistCookie) {
            Cookie::queue(
                cookie(
                    'poll_voter_id',
                    $voterId,
                    60 * 24 * 365,
                ),
            );
        }

        $this->voterHash = hash_hmac(
            'sha256',
            $voterId,
            config('app.key'),
        );

        return $this->voterHash;
    }

    protected function existingVote(): ?PollVote
    {
        if (! $this->poll) {
            return null;
        }

        $query = $this->poll->votes();

        $voterHash = $this->getVoterHash();

        if (auth()->check()) {
            return $query
                ->where(function ($query) use ($voterHash) {
                    $query->where('user_id', auth()->id())
                        ->orWhere('voter_hash', $voterHash);
                })
                ->first();
        }

        return $query
            ->where('voter_hash', $voterHash)
            ->first();
    }

    /*
    |--------------------------------------------------------------------------
    | Results
    |--------------------------------------------------------------------------
    */

    public function getResults(): array
    {
        if (! $this->poll) {
            return [
                'total' => 0,
                'options' => [],
            ];
        }

        $options = $this->poll->options()
            ->withCount('votes')
            ->get();

        $total = $options->sum('votes_count');

        return [
            'total' => $total,

            'options' => $options->map(function ($option) use ($total) {
                $votes = (int) $option->votes_count;

                return [
                    'id' => $option->id,
                    'label' => $option->label,
                    'votes' => $votes,
                    'percentage' => $total > 0
                        ? round(($votes / $total) * 100)
                        : 0,
                ];
            })->all(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        if ($this->poll) {
            $this->hasVoted = $this->existingVote() !== null;

            if ($this->hasVoted || ! $this->poll->isOpen()) {
                $this->showResults = true;
            }
        }

        return $this->view([
            'results' => $this->showResults
                ? $this->getResults()
                : [
                    'total' => 0,
                    'options' => [],
                ],
        ]);
    }
};

?>

<div class="poll bg-[#FAFAFA] rounded-lg p-6 flex flex-col gap-6 md:col-span-2 xl:col-span-1 shadow-lg transition duration-300 hover:shadow-xl">

    @if ($poll)

        <div class="poll__header flex flex-col gap-2">

            <div class="flex items-center gap-2 text-xs uppercase font-display font-black tracking-wider text-[var(--color-primary)]">

                <span class="w-2 h-2 rounded-full bg-[var(--color-primary)]"></span>

                {{ __('general.poll') }}

            </div>

            <h3 class="poll__title text-xl font-display font-black text-[var(--color-secondary)] leading-snug">{{ $poll->question }}</h3>

            @if ($poll->description)

                <p class="poll__description text-sm font-light text-[var(--color-secondary)]/80 leading-relaxed">{{ $poll->description }}</p>

            @endif

        </div>

        <div class="poll__content flex flex-col gap-4">

            @if ($showResults)

                <div class="poll__results flex flex-col gap-5">

                    @foreach ($results['options'] as $result)

                        <div wire:key="poll-result-{{ $poll->id }}-{{ $result['id'] }}" class="poll__result flex flex-col gap-2">

                            <div class="poll__result-header flex items-center justify-between gap-4">

                                <span class="poll__result-label text-sm font-bold text-[var(--color-secondary)]">{{ $result['label'] }}</span>

                                <span class="poll__result-percentage text-sm font-display font-black text-[var(--color-primary)] tabular-nums">{{ $result['percentage'] }}%</span>

                            </div>

                            <div class="poll__progress w-full h-2.5 bg-gray-200 rounded-full overflow-hidden"
                                 role="progressbar"
                                 aria-label="{{ $result['label'] }}"
                                 aria-valuenow="{{ $result['percentage'] }}"
                                 aria-valuemin="0"
                                 aria-valuemax="100">

                                <div class="poll__progress-bar h-full rounded-full bg-[var(--color-primary)] transition-all duration-700 ease-out" style="width: {{ $result['percentage'] }}%"></div>

                            </div>

                            <span class="poll__result-votes text-xs font-light text-[var(--color-secondary)]/70">
                                {{ trans_choice(
                                    'general.poll_votes',
                                    $result['votes'],
                                    ['count' => $result['votes']]
                                ) }}
                            </span>

                        </div>

                    @endforeach

                    <div class="poll__total border-t border-gray-200 pt-4 flex items-center justify-between">

                        <span class="text-xs uppercase font-display font-black tracking-wider text-[var(--color-secondary)]/70">{{ __('general.poll_total') }}</span>

                        <span class="text-sm font-display font-black text-[var(--color-secondary)]">
                            {{ trans_choice(
                                'general.poll_total_votes',
                                $results['total'],
                                ['count' => $results['total']]
                            ) }}
                        </span>

                    </div>

                </div>

            @endif

            @if (! $hasVoted && $poll->isOpen())

                <div class="poll__options flex flex-col gap-2">

                    @foreach ($poll->options as $option)

                        <button type="button"
                                wire:key="poll-option-{{ $poll->id }}-{{ $option->id }}"
                                wire:click="vote({{ $option->id }})"
                                wire:loading.attr="disabled"
                                wire:target="vote"
                                class="poll__option group cursor-pointer w-full flex items-center justify-between gap-4 px-4 py-3 text-left bg-white border border-gray-200 rounded-md transition duration-300 hover:border-[var(--color-primary)] hover:shadow-md hover:bg-[var(--color-primary)]/5 focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--color-primary)] focus-visible:ring-offset-2 disabled:opacity-60 disabled:cursor-wait">

                            <span class="poll__option-label text-sm font-bold text-[var(--color-secondary)] transition duration-300 group-hover:text-[var(--color-primary)]">{{ $option->label }}</span>

                            <span wire:loading.remove
                                  wire:target="vote"
                                  class="poll__option-action flex items-center justify-center w-8 h-8 shrink-0 rounded-full bg-gray-100 text-[var(--color-secondary)] transition duration-300 group-hover:bg-[var(--color-primary)] group-hover:text-white">

                                <span aria-hidden="true" class="text-lg leading-none">&rarr;</span>

                            </span>

                            <span wire:loading
                                  wire:target="vote"
                                  class="poll__option-loading text-xs font-bold text-[var(--color-primary)]">

                                {{ __('general.loading') }}

                            </span>

                        </button>

                    @endforeach

                </div>

                @error('vote')
                    <p class="poll__error text-sm text-red-600 bg-red-50 border border-red-200 rounded-md px-4 py-3" role="alert">{{ $message }}</p>
                @enderror

            @endif

            @if ($justVoted)
                <p class="poll__success flex items-center gap-2 text-sm font-bold text-green-700 bg-green-50 border border-green-200 rounded-md px-4 py-3" role="status">
                    <span aria-hidden="true" class="text-lg">&check;</span>
                    {{ __('general.poll_thank_you') }}
                </p>
            @endif

            @if (! $poll->isOpen())
                <p class="poll__closed text-sm font-bold text-[var(--color-secondary)]/70 bg-gray-100 rounded-md px-4 py-3">{{ __('general.poll_closed') }}</p>
            @endif

        </div>

    @endif

</div>