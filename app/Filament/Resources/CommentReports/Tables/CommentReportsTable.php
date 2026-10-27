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
                    ->label(__('admin.id'))
                    ->sortable(),

                TextColumn::make('comment.article.title')
                    ->label(__('admin.article'))
                    ->placeholder(__('admin.article_unavailable'))
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('comment.body')
                    ->label(__('admin.reported_comment'))
                    ->placeholder(__('admin.comment_unavailable'))
                    ->limit(80)
                    ->wrap(),

                TextColumn::make('reporter_name')
                    ->label(__('admin.reporter'))
                    ->state(fn (CommentReport $record): string => filled($record->reporter?->display_name)
                        ? $record->reporter->display_name
                        : (filled(trim(($record->first_name ?? '').' '.($record->last_name ?? '')))
                            ? trim(($record->first_name ?? '').' '.($record->last_name ?? ''))
                            : __('admin.guest')))
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
                    ->label(__('admin.reason'))
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'spam' => __('admin.spam_or_advertising'),
                        'harassment' => __('admin.harassment_or_bullying'),
                        'hate_speech' => __('admin.hate_speech'),
                        'inappropriate_content' => __('admin.inappropriate_content'),
                        'other' => __('admin.other'),
                        default => str($state)->headline()->toString(),
                    })
                    ->searchable()
                    ->wrap(),

                TextColumn::make('status')
                    ->label(__('admin.status'))
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        CommentReport::STATUS_PENDING => __('admin.pending'),
                        CommentReport::STATUS_REVIEWING => __('admin.reviewing'),
                        CommentReport::STATUS_RESOLVED => __('admin.resolved'),
                        CommentReport::STATUS_DISMISSED => __('admin.dismissed'),
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
                    ->label(__('admin.reported'))
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('reviewer.display_name')
                    ->label(__('admin.reviewed_by'))
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('reviewed_at')
                    ->label(__('admin.reviewed_at'))
                    ->dateTime()
                    ->placeholder('—')
                    ->toggleable(),
            ])

            ->filters([
                SelectFilter::make('status')
                    ->label(__('admin.status'))
                    ->options([
                        CommentReport::STATUS_PENDING => __('admin.pending'),
                        CommentReport::STATUS_REVIEWING => __('admin.reviewing'),
                        CommentReport::STATUS_RESOLVED => __('admin.resolved'),
                        CommentReport::STATUS_DISMISSED => __('admin.dismissed'),
                    ]),
            ])

            ->recordActions([
                Action::make('view')
                    ->label(__('admin.view_report'))
                    ->icon('heroicon-o-eye')
                    ->url(fn (CommentReport $record): string => CommentReportResource::getUrl('view', [
                        'record' => $record,
                    ])),

                Action::make('viewComment')
                    ->label(__('admin.view_comment'))
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->url(fn (CommentReport $record): ?string => $record->comment
                        ? CommentResource::getUrl('edit', [
                            'record' => $record->comment_id,
                        ])
                        : null)
                    ->visible(fn (CommentReport $record): bool => $record->comment !== null)
                    ->openUrlInNewTab(),

                Action::make('markReviewing')
                    ->label(__('admin.mark_reviewing'))
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->visible(fn (CommentReport $record): bool => $record->status === CommentReport::STATUS_PENDING)
                    ->action(fn (CommentReport $record) => self::updateStatus(
                        $record,
                        CommentReport::STATUS_REVIEWING,
                    )),

                Action::make('resolve')
                    ->label(__('admin.resolve'))
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading(__('admin.resolve_report'))
                    ->modalDescription(__('admin.confirm_resolve_report'))
                    ->visible(fn (CommentReport $record): bool => in_array($record->status, [
                        CommentReport::STATUS_PENDING,
                        CommentReport::STATUS_REVIEWING,
                    ], true))
                    ->action(fn (CommentReport $record) => self::updateStatus(
                        $record,
                        CommentReport::STATUS_RESOLVED,
                    )),

                Action::make('dismiss')
                    ->label(__('admin.dismiss'))
                    ->icon('heroicon-o-x-circle')
                    ->color('gray')
                    ->requiresConfirmation()
                    ->modalHeading(__('admin.dismiss_report'))
                    ->modalDescription(__('admin.confirm_dismiss_report'))
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