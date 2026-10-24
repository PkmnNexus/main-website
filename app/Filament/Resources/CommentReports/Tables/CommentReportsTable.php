<?php

namespace App\Filament\Resources\CommentReports\Tables;

use App\Filament\Resources\CommentReports\CommentReportResource;
use App\Filament\Resources\Comments\CommentResource;
use App\Models\CommentReport;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;

class CommentReportsTable
{
    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    */

    /**
     * Configure the comment reports table.
     */
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')

            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('comment.article.title')
                    ->label('Article')
                    ->placeholder('Article unavailable')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('comment.body')
                    ->label('Reported comment')
                    ->placeholder('Comment unavailable')
                    ->limit(80)
                    ->wrap(),

                TextColumn::make('reporter_name')
                    ->label('Reporter')
                    ->state(fn (CommentReport $record): string => filled($record->reporter?->display_name)
                        ? $record->reporter->display_name
                        : (filled(trim(($record->first_name ?? '').' '.($record->last_name ?? '')))
                            ? trim(($record->first_name ?? '').' '.($record->last_name ?? ''))
                            : 'Guest'))
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->where(function (Builder $query) use ($search): void {
                            $query
                                ->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                    })
                    ->wrap(),

                TextColumn::make('reason')
                    ->label('Reason')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'spam' => 'Spam or advertising',
                        'harassment' => 'Harassment or bullying',
                        'hate_speech' => 'Hate speech',
                        'inappropriate_content' => 'Inappropriate content',
                        'other' => 'Other',
                        default => str($state)->headline()->toString(),
                    })
                    ->searchable()
                    ->wrap(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        CommentReport::STATUS_PENDING => 'Pending',
                        CommentReport::STATUS_REVIEWING => 'Reviewing',
                        CommentReport::STATUS_RESOLVED => 'Resolved',
                        CommentReport::STATUS_DISMISSED => 'Dismissed',
                        default => str($state)->headline()->toString(),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        CommentReport::STATUS_PENDING => 'warning',
                        CommentReport::STATUS_REVIEWING => 'info',
                        CommentReport::STATUS_RESOLVED => 'success',
                        CommentReport::STATUS_DISMISSED => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Reported')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('reviewer.display_name')
                    ->label('Reviewed by')
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('reviewed_at')
                    ->label('Reviewed at')
                    ->dateTime()
                    ->placeholder('—')
                    ->toggleable(),
            ])

            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        CommentReport::STATUS_PENDING => 'Pending',
                        CommentReport::STATUS_REVIEWING => 'Reviewing',
                        CommentReport::STATUS_RESOLVED => 'Resolved',
                        CommentReport::STATUS_DISMISSED => 'Dismissed',
                    ]),
            ])

            ->recordActions([
                Action::make('view')
                    ->label('View report')
                    ->icon('heroicon-o-eye')
                    ->url(fn (CommentReport $record): string => CommentReportResource::getUrl('view', [
                        'record' => $record,
                    ])),

                Action::make('viewComment')
                    ->label('View comment')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->url(fn (CommentReport $record): ?string => $record->comment
                        ? CommentResource::getUrl('edit', [
                            'record' => $record->comment_id,
                        ])
                        : null)
                    ->visible(fn (CommentReport $record): bool => $record->comment !== null)
                    ->openUrlInNewTab(),

                Action::make('markReviewing')
                    ->label('Mark reviewing')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->visible(fn (CommentReport $record): bool => $record->status === CommentReport::STATUS_PENDING)
                    ->action(fn (CommentReport $record) => self::updateStatus(
                        $record,
                        CommentReport::STATUS_REVIEWING,
                    )),

                Action::make('resolve')
                    ->label('Resolve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Resolve report')
                    ->modalDescription('Mark this report as resolved?')
                    ->visible(fn (CommentReport $record): bool => in_array($record->status, [
                        CommentReport::STATUS_PENDING,
                        CommentReport::STATUS_REVIEWING,
                    ], true))
                    ->action(fn (CommentReport $record) => self::updateStatus(
                        $record,
                        CommentReport::STATUS_RESOLVED,
                    )),

                Action::make('dismiss')
                    ->label('Dismiss')
                    ->icon('heroicon-o-x-circle')
                    ->color('gray')
                    ->requiresConfirmation()
                    ->modalHeading('Dismiss report')
                    ->modalDescription('Mark this report as dismissed?')
                    ->visible(fn (CommentReport $record): bool => in_array($record->status, [
                        CommentReport::STATUS_PENDING,
                        CommentReport::STATUS_REVIEWING,
                    ], true))
                    ->action(fn (CommentReport $record) => self::updateStatus(
                        $record,
                        CommentReport::STATUS_DISMISSED,
                    )),
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Update the report status and record the reviewing moderator.
     */
    private static function updateStatus(
        CommentReport $record,
        string $status,
    ): void {
        Gate::authorize('update', $record);

        abort_unless(in_array($status, [
            CommentReport::STATUS_REVIEWING,
            CommentReport::STATUS_RESOLVED,
            CommentReport::STATUS_DISMISSED,
        ], true), 422);

        $record->update([
            'status' => $status,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);
    }
}