<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleDailyView extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleDailyViewFactory> */
    use HasFactory;

    protected $fillable = [
        'article_id',
        'view_date',
        'views',
    ];

    protected function casts(): array
    {
        return [
            'view_date' => 'date',
            'views' => 'integer',
        ];
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
