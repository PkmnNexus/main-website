<?php

namespace App\Filament\Resources\Comments\Tables;

use App\Models\Comment;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class CommentsTable
{
    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    */

    /**
     * Configure the comments table.
     */
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')

            ->columns([
                TextColumn::make('id')
                    ->label(__('admin.id'))
                    ->sortable(),

                TextColumn::make('article.title')
                    ->label(__('admin.article'))
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('user.display_name')
                    ->label(__('admin.author'))
                    ->searchable()
                    ->sortable()
                    ->placeholder(__('admin.former_member'))
                    ->wrap(),

                TextColumn::make('body')
                    ->label(__('admin.comment'))
                    ->searchable()
                    ->limit(100)
                    ->wrap(),

                TextColumn::make('created_at')
                    ->label(__('admin.posted'))
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('deleted_at')
                    ->label(__('admin.deleted'))
                    ->dateTime()
                    ->placeholder('—')
                    ->toggleable(),
            ])

            ->filters([
                TrashedFilter::make(),
            ])

            ->recordActions([
                EditAction::make(),

                DeleteAction::make()
                    ->visible(fn (Comment $record): bool => ! self::isOwnComment($record)),

                RestoreAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->action(function (Collection $records): void {
                            if ($records->contains(
                                fn (Comment $record): bool => self::isOwnComment($record)
                            )) {
                                Notification::make()
                                    ->danger()
                                    ->title(__('admin.cannot_delete_own_comments'))
                                    ->body(__('admin.remove_own_comments_before_deleting'))
                                    ->send();

                                return;
                            }

                            $records->each(
                                fn (Comment $record) => $record->delete()
                            );
                        }),

                    RestoreBulkAction::make(),
                ]),
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Determine whether the comment belongs to the authenticated user.
     */
    private static function isOwnComment(Comment $comment): bool
    {
        $userId = auth()->id();

        return $userId !== null
            && (int) $comment->user_id === (int) $userId;
    }
}