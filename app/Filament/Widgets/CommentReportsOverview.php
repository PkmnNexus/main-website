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
            ->heading('Comment reports')
            ->description('Recent reports that require attention.')
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
                    ->label('Reported comment')
                    ->limit(70)
                    ->tooltip(fn (CommentReport $record): string =>
                        $record->comment?->body ?? 'Comment unavailable'
                    )
                    ->placeholder('Comment unavailable'),

                TextColumn::make('reason')
                    ->label('Reason')
                    ->badge()
                    ->searchable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        CommentReport::STATUS_PENDING => 'warning',
                        CommentReport::STATUS_REVIEWING => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('Reported')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        CommentReport::STATUS_PENDING => 'Pending',
                        CommentReport::STATUS_REVIEWING => 'Reviewing',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated(false)
            ->emptyStateHeading('No reports require attention')
            ->emptyStateDescription(
                'New pending reports will appear here.'
            );
    }
}