<?php

namespace App\Filament\Widgets;

use App\Enums\ArticleStatus;
use App\Models\Article;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class UpcomingPublications extends TableWidget
{
    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    */

    protected static ?int $sort = 2;

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
            ->heading('Upcoming publications')
            ->description('Articles scheduled for publication in the future.')
            ->query(
                Article::query()
                    ->where('status', ArticleStatus::Published->value)
                    ->where('published_at', '>', now())
                    ->where(function ($query): void {
                        $query
                            ->whereNull('expires_at')
                            ->orWhere('expires_at', '>', now());
                    })
                    ->orderBy('published_at')
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('title')
                    ->label('Article')
                    ->searchable()
                    ->limit(60)
                    ->tooltip(fn (Article $record): string => $record->title),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->placeholder('Uncategorized'),

                TextColumn::make('published_at')
                    ->label('Publication date')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('published_at', 'asc')
            ->paginated(false)
            ->emptyStateHeading('No upcoming publications')
            ->emptyStateDescription(
                'Scheduled articles will appear here once they have a future publication date.'
            );
    }
}