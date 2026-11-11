<?php

namespace App\Filament\Resources\Categories\Tables;

use Asignua\FilamentTranslatableFields\Tables\TranslatableColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label(__('admin.key'))
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TranslatableColumn::make('name')
                    ->label(__('admin.name'))
                    ->searchable(
                        query: fn (Builder $query, string $search): Builder => $query
                            ->where(
                                'name->'.app()->getLocale(),
                                'like',
                                "%{$search}%",
                            ),
                    )
                    ->sortableByLocale()
                    ->weight('medium'),

                TranslatableColumn::make('slug')
                    ->label(__('admin.slug'))
                    ->searchable(
                        query: fn (Builder $query, string $search): Builder => $query
                            ->where(
                                'slug->'.app()->getLocale(),
                                'like',
                                "%{$search}%",
                            ),
                    )
                    ->sortableByLocale()
                    ->copyable()
                    ->copyMessage(__('admin.slug_copied'))
                    ->toggleable(),

                TextColumn::make('articles_count')
                    ->label(__('admin.articles'))
                    ->counts('articles')
                    ->badge()
                    ->color(fn (int $state) => $state === 0 ? 'gray' : 'primary')
                    ->sortable(),

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