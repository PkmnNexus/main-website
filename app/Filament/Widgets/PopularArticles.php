<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use Carbon\Carbon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class PopularArticles extends TableWidget
{
    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    */

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 2,
    ];

    /*
    |--------------------------------------------------------------------------
    | Table
    |--------------------------------------------------------------------------
    */

    public function table(Table $table): Table
    {
        return $table
            ->heading(__('admin.popular_articles'))
            ->description(__('admin.popular_articles_description'))
            ->query(
                Article::query()
                    ->published()
                    ->join(
                        'article_daily_views',
                        'articles.id',
                        '=',
                        'article_daily_views.article_id',
                    )
                    ->select('articles.*')
                    ->selectRaw('SUM(article_daily_views.views) as period_views')
                    ->groupBy('articles.id')
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('title')
                    ->label(__('admin.article'))
                    ->searchable()
                    ->limit(60)
                    ->tooltip(fn (Article $record): string => $record->title),

                TextColumn::make('period_views')
                    ->label(__('admin.views'))
                    ->numeric()
                    ->sortable()
                    ->default(0),

                TextColumn::make('published_at')
                    ->label(__('admin.published'))
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('period')
                    ->label(__('admin.period'))
                    ->options([
                        'all' => __('admin.all_time'),
                        'today' => __('admin.today'),
                        'week' => __('admin.this_week'),
                        'month' => __('admin.this_month'),
                    ])
                    ->default('week')
                    ->query(function (Builder $query, array $data): Builder {
                        $period = $data['value'] ?? 'week';

                        if ($period === 'all') {
                            return $query;
                        }

                        [$startDate, $endDate] = match ($period) {
                            'today' => [
                                now()->startOfDay()->toDateString(),
                                now()->endOfDay()->toDateString(),
                            ],
                            'month' => [
                                now()->startOfMonth()->toDateString(),
                                now()->endOfMonth()->toDateString(),
                            ],
                            default => [
                                now()->startOfWeek(Carbon::MONDAY)->toDateString(),
                                now()->endOfWeek(Carbon::SUNDAY)->toDateString(),
                            ],
                        };

                        return $query->whereBetween(
                            'article_daily_views.view_date',
                            [$startDate, $endDate],
                        );
                    })
            ])
            ->defaultSort('period_views', 'desc')
            ->paginated(false)
            ->emptyStateHeading(__('admin.no_article_views_yet'))
            ->emptyStateDescription(
                __('admin.published_articles_will_appear_after_receiving_views')
            );
    }
}