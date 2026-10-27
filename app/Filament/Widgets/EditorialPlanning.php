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
            ->heading(__('admin.editorial_planning'))
            ->description(__('admin.editorial_planning_description'))
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
                    ->label(__('admin.article'))
                    ->searchable()
                    ->limit(60)
                    ->tooltip(fn (Article $record): string => $record->title),

                TextColumn::make('status')
                    ->label(__('admin.status'))
                    ->badge()
                    ->formatStateUsing(
                        fn (Article $record): string => match ($record->status) {
                            ArticleStatus::Draft => __('admin.draft'),
                            ArticleStatus::Pending => __('admin.pending'),
                            ArticleStatus::Published => $record->published_at?->isFuture()
                                ? __('admin.scheduled')
                                : __('admin.published'),
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
                    ->label(__('admin.publication_date'))
                    ->dateTime('d M Y, H:i')
                    ->placeholder(__('admin.not_scheduled'))
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('admin.created'))
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('published_at', 'asc')
            ->paginated(false)
            ->emptyStateHeading(__('admin.no_articles_to_plan'))
            ->emptyStateDescription(
                __('admin.editorial_planning_empty_description')
            );
    }
}