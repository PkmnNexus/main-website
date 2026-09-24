<?php

namespace App\Filament\Resources\Articles\Tables;

use App\Enums\ArticleStatus;
use App\Models\Article;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ArticlesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('published_at', 'desc')
            ->columns([
                TextColumn::make('title')
                    ->label('Articles')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->description(fn (Article $record) => $record->slug)
                    ->limit(70),
                IconColumn::make('is_featured')
                    ->label('')
                    ->boolean()
                    ->trueIcon('heroicon-m-star')
                    ->falseIcon('')
                    ->trueColor('primary'),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Author')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => $state?->getLabel())
                    ->color(fn ($state) => $state?->getColor()),
                TextColumn::make('published_at')
                    ->label('Published')
                    ->since()
                    ->sortable(),
                TextColumn::make('views')
                    ->label('Views')
                    ->numeric()
                    ->alignEnd()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(
                        collect(ArticleStatus::cases())
                            ->mapWithKeys(fn (ArticleStatus $status) => [
                                $status->value => $status->getLabel(),
                            ])
                            ->toArray()
                    ),

                SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('user')
                    ->label('Author')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),

                Filter::make('featured')
                    ->label('Only featured')
                    ->query(fn (Builder $query): Builder => $query->where('is_featured', true)),

                Filter::make('pokemon_go_featured')
                    ->label('Only Pokémon GO featured')
                    ->query(fn (Builder $query): Builder => $query->where('is_pokemon_go_featured', true)),
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