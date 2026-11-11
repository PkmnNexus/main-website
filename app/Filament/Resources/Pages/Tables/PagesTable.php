<?php

namespace App\Filament\Resources\Pages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('page')
                    ->label(__('admin.page'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('title')
                    ->label(__('admin.title'))
                    ->sortable()
                    ->searchable(
                        query: fn (Builder $query, string $search): Builder => $query
                            ->whereRaw(
                                'JSON_UNQUOTE(JSON_EXTRACT(title, ?)) COLLATE utf8mb4_unicode_ci LIKE ?',
                                ['$."'.app()->getLocale().'"', "%{$search}%"],
                            ),
                    ),

                IconColumn::make('robots_index')
                    ->label(__('admin.allow_indexing'))
                    ->boolean(),

                IconColumn::make('robots_follow')
                    ->label(__('admin.follow_links'))
                    ->boolean(),

                IconColumn::make('is_active')
                    ->label(__('admin.published'))
                    ->boolean(),
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