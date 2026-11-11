<?php

namespace App\Filament\Resources\PokemonTcgCards\Tables;

use App\Models\PokemonTcgCard;
use App\Models\PokemonTcgSet;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PokemonTcgCardsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('display_thumbnail_url')
                    ->label(__('admin.image'))
                    ->height(65)
                    ->width(48)
                    ->state(fn (PokemonTcgCard $record): ?string => $record->display_thumbnail_url),

                TextColumn::make('api_local_id')
                    ->label(__('admin.local_id'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('display_name')
                    ->label(__('admin.name'))
                    ->searchable(['name', 'api_name'])
                    ->sortable(),

                TextColumn::make('set.display_name')
                    ->label(__('admin.set'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('api_category')
                    ->label(__('admin.category'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('api_rarity')
                    ->label(__('admin.rarity'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('external_id')
                    ->label(__('admin.external_id'))
                    ->searchable()
                    ->sortable()
                    ->copyable(),

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
                SelectFilter::make('set_id')
                    ->label(__('admin.set'))
                    ->options(fn (): array => PokemonTcgSet::query()
                        ->orderBy('api_name')
                        ->get()
                        ->mapWithKeys(fn (PokemonTcgSet $set): array => [
                            $set->id => $set->display_name,
                        ])
                        ->all()),

                SelectFilter::make('api_category')
                    ->label(__('admin.category'))
                    ->options(fn (): array => PokemonTcgCard::query()
                        ->whereNotNull('api_category')
                        ->distinct()
                        ->orderBy('api_category')
                        ->pluck('api_category', 'api_category')
                        ->all()),

                SelectFilter::make('api_rarity')
                    ->label(__('admin.rarity'))
                    ->options(fn (): array => PokemonTcgCard::query()
                        ->whereNotNull('api_rarity')
                        ->distinct()
                        ->orderBy('api_rarity')
                        ->pluck('api_rarity', 'api_rarity')
                        ->all()),
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

    protected static function formatPriceSummary(PokemonTcgCard $record): string
    {
        $record->loadMissing('prices');

        if ($record->prices->isEmpty()) {
            return '—';
        }

        return $record->prices
            ->map(function ($price): ?string {
                $data = $price->price_data ?? [];

                if (! is_array($data)) {
                    return null;
                }

                $amount = $data['avg']
                    ?? $data['marketPrice']
                    ?? $data['holofoil']['marketPrice']
                    ?? $data['holofoil']['midPrice']
                    ?? null;

                if (! is_numeric($amount)) {
                    return null;
                }

                $variant = $price->variant_key === 'card'
                    ? ''
                    : ' ('.implode(' / ', array_filter([
                        $price->variant_type,
                        $price->variant_subtype,
                    ])).')';

                return strtoupper($price->source)
                    .$variant
                    .': '
                    .($price->currency ?? '')
                    .' '
                    .number_format((float) $amount, 2, '.', '');
            })
            ->filter()
            ->take(3)
            ->implode(' | ') ?: '—';
    }
}