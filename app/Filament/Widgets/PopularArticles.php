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
            ->heading('Popular articles')
            ->description('Your 10 most viewed published articles for the selected period.')
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
                    ->label('Article')
                    ->searchable()
                    ->limit(60)
                    ->tooltip(fn (Article $record): string => $record->title),

                TextColumn::make('period_views')
                    ->label('Views')
                    ->numeric()
                    ->sortable()
                    ->default(0),

                TextColumn::make('published_at')
                    ->label('Published')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('period')
                    ->label('Period')
                    ->options([
                        'today' => 'Today',
                        'week' => 'This week',
                        'month' => 'This month',
                    ])
                    ->default('week')
                    ->query(function (Builder $query, array $data): Builder {
                        $period = $data['value'] ?? 'week';

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
                    }),
            ])
            ->defaultSort('period_views', 'desc')
            ->paginated(false)
            ->emptyStateHeading('No article views yet')
            ->emptyStateDescription(
                'Published articles will appear here once they receive views.'
            );
    }
}