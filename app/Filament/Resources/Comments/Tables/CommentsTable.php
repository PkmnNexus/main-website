<?php

namespace App\Filament\Resources\Comments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

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
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('article.title')
                    ->label('Article')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('user.display_name')
                    ->label('Author')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Former member')
                    ->wrap(),

                TextColumn::make('body')
                    ->label('Comment')
                    ->searchable()
                    ->limit(100)
                    ->wrap(),

                TextColumn::make('created_at')
                    ->label('Posted')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('deleted_at')
                    ->label('Deleted')
                    ->dateTime()
                    ->placeholder('—')
                    ->toggleable(),
            ])

            ->filters([
                TrashedFilter::make(),
            ])

            ->recordActions([
                EditAction::make(),

                DeleteAction::make(),

                RestoreAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),

                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}