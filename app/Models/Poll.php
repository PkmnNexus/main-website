<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Poll extends Model
{
    use HasTranslations;
    use SoftDeletes;

    protected $fillable = [
        'question',
        'description',
        'is_active',
        'show_results_before_vote',
        'starts_at',
        'ends_at',
    ];

    public array $translatable = [
        'question',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'show_results_before_vote' => 'boolean',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }

    public function options(): HasMany
    {
        return $this->hasMany(PollOption::class)
            ->orderBy('sort_order');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(PollVote::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->where(function (Builder $query) {
                $query->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', now());
            })
            ->where(function (Builder $query) {
                $query->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', now());
            });
    }

    public function isOpen(): bool
    {
        return $this->is_active
            && (! $this->starts_at || $this->starts_at->isPast())
            && (! $this->ends_at || $this->ends_at->isFuture());
    }

    public function getTotalVotesAttribute(): int
    {
        return $this->votes()->count();
    }
}