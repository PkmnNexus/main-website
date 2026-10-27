<?php

namespace App\Filament\Widgets;

use App\Models\CommentReport;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class CommentReportsOverview extends TableWidget
{
    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    */

    protected static ?int $sort = 3;

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
            ->heading(__('admin.comment_reports'))
            ->description(__('admin.recent_reports_require_attention'))
            ->query(
                CommentReport::query()
                    ->whereIn('status', [
                        CommentReport::STATUS_PENDING,
                        CommentReport::STATUS_REVIEWING,
                    ])
                    ->with('comment')
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('comment.body')
                    ->label(__('admin.reported_comment'))
                    ->limit(70)
                    ->tooltip(fn (CommentReport $record): string =>
                        $record->comment?->body ?? __('admin.comment_unavailable')
                    )
                    ->placeholder(__('admin.comment_unavailable')),

                TextColumn::make('reason')
                    ->label(__('admin.reason'))
                    ->badge()
                    ->searchable(),

                TextColumn::make('status')
                    ->label(__('admin.status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        CommentReport::STATUS_PENDING => 'warning',
                        CommentReport::STATUS_REVIEWING => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label(__('admin.reported'))
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('admin.status'))
                    ->options([
                        CommentReport::STATUS_PENDING => __('admin.pending'),
                        CommentReport::STATUS_REVIEWING => __('admin.reviewing'),
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated(false)
            ->emptyStateHeading(__('admin.no_reports_require_attention'))
            ->emptyStateDescription(
                __('admin.new_pending_reports_will_appear_here')
            );
    }
}