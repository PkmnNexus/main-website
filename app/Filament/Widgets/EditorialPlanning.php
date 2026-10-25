<?php

namespace App\Filament\Widgets;

use App\Enums\ArticleStatus;
use App\Models\Article;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class EditorialPlanning extends TableWidget
{
    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    */

    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 1,
    ];

    /*
    |--------------------------------------------------------------------------
    | Table
    |--------------------------------------------------------------------------
    */

    public function table(Table $table): Table
    {
        return $table
            ->heading('Editorial planning')
            ->description('Drafts, pending articles and upcoming publications.')
            ->query(
                Article::query()
                    ->where(function (Builder $query): void {
                        $query
                            ->whereIn('status', [
                                ArticleStatus::Draft->value,
                                ArticleStatus::Pending->value,
                            ])
                            ->orWhere(function (Builder $query): void {
                                $query
                                    ->where('status', ArticleStatus::Published->value)
                                    ->where('published_at', '>', now());
                            });
                    })
                    ->orderByRaw(
                        'CASE WHEN published_at IS NULL THEN 1 ELSE 0 END'
                    )
                    ->orderBy('published_at')
                    ->latest('created_at')
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('title')
                    ->label('Article')
                    ->searchable()
                    ->limit(60)
                    ->tooltip(fn (Article $record): string => $record->title),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(
                        fn (Article $record): string => match ($record->status) {
                            ArticleStatus::Draft => 'Draft',
                            ArticleStatus::Pending => 'Pending',
                            ArticleStatus::Published => $record->published_at?->isFuture()
                                ? 'Scheduled'
                                : 'Published',
                            default => $record->status->value,
                        }
                    )
                    ->color(
                        fn (Article $record): string => match ($record->status) {
                            ArticleStatus::Draft => 'gray',
                            ArticleStatus::Pending => 'warning',
                            ArticleStatus::Published => 'success',
                            default => 'gray',
                        }
                    ),

                TextColumn::make('published_at')
                    ->label('Publication date')
                    ->dateTime('d M Y, H:i')
                    ->placeholder('Not scheduled')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('published_at', 'asc')
            ->paginated(false)
            ->emptyStateHeading('No articles to plan')
            ->emptyStateDescription(
                'Drafts, pending articles and scheduled publications will appear here.'
            );
    }
}