<?php

namespace App\Filament\Resources\Polls\Tables;

use Asignua\FilamentTranslatableFields\Tables\TranslatableColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PollsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TranslatableColumn::make('question')
                    ->label(__('admin.question'))
                    ->searchAcrossLocales()
                    ->sortableByLocale()
                    ->weight('medium'),

                IconColumn::make('is_active')
                    ->label(__('admin.is_active'))
                    ->boolean(),

                TextColumn::make('options_count')
                    ->label(__('admin.options'))
                    ->counts('options')
                    ->badge()
                    ->color(fn (int $state) => $state === 0 ? 'gray' : 'primary')
                    ->sortable(),

                TextColumn::make('votes_count')
                    ->label(__('admin.votes'))
                    ->counts('votes')
                    ->badge()
                    ->color(fn (int $state) => $state === 0 ? 'gray' : 'success')
                    ->sortable(),

                TextColumn::make('starts_at')
                    ->label(__('admin.starts_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('ends_at')
                    ->label(__('admin.ends_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}