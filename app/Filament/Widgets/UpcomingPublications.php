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
            ->heading(__('admin.upcoming_publications'))
            ->description(__('admin.upcoming_publications_description'))
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
                    ->label(__('admin.article'))
                    ->searchable()
                    ->limit(60)
                    ->tooltip(fn (Article $record): string => $record->title),

                TextColumn::make('category.name')
                    ->label(__('admin.category'))
                    ->placeholder(__('admin.uncategorized')),

                TextColumn::make('published_at')
                    ->label(__('admin.publication_date'))
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('admin.created'))
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('published_at', 'asc')
            ->paginated(false)
            ->emptyStateHeading(__('admin.no_upcoming_publications'))
            ->emptyStateDescription(
                __('admin.scheduled_articles_will_appear_when_publication_date_is_future')
            );
    }
}