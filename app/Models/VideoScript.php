<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VideoScript extends Model
{
    protected $fillable = [
        'title',
        'platforms',
        'category_id',
        'content',
        'word_count',
        'estimated_duration',
        'target_duration',
        'status',
        'published_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'platforms' => 'array',
            'word_count' => 'integer',
            'estimated_duration' => 'integer',
            'target_duration' => 'integer',
            'published_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (VideoScript $videoScript) {
            $videoScript->calculateStatistics();
        });
    }

    protected function calculateStatistics(): void
    {
        // Remove HTML formatting from the script.
        $plainText = strip_tags($this->content ?? '');

        // Decode HTML entities and normalize whitespace.
        $plainText = html_entity_decode(
            $plainText,
            ENT_QUOTES | ENT_HTML5,
            'UTF-8'
        );

        $plainText = preg_replace('/\s+/u', ' ', $plainText);

        // Count words, including words with accented characters.
        preg_match_all(
            '/[\p{L}\p{N}]+(?:[\'’\-][\p{L}\p{N}]+)*/u',
            $plainText,
            $matches
        );

        $this->word_count = count($matches[0]);

        // Estimate speaking duration at 150 words per minute.
        $this->estimated_duration = (int) ceil(
            ($this->word_count / 150) * 60
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(VideoScriptCategory::class, 'category_id');
    }
}