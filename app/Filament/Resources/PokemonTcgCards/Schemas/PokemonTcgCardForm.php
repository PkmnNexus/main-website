<?php

namespace App\Filament\Resources\PokemonTcgCards\Schemas;

use App\Filament\Forms\Components\Media\AssetPicker;
use App\Models\PokemonTcgSet;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class PokemonTcgCardForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(12)
                    ->schema([
                        Section::make(__('admin.general'))
                            ->schema([
                                Select::make('set_id')
                                    ->label(__('admin.set'))
                                    ->relationship('set', 'api_name')
                                    ->getOptionLabelFromRecordUsing(fn (PokemonTcgSet $record): string => $record->display_name)
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                TextInput::make('name')
                                    ->label(__('admin.name'))
                                    ->maxLength(255)
                                    ->nullable()
                                    ->helperText(__('admin.pokemon_tcg_card_name_helper')),

                                AssetPicker::make('image_asset_id')
                                    ->label(__('admin.image')),
                            ])
                            ->columnSpan(7),

                        Section::make(__('admin.image'))
                            ->schema([
                                Placeholder::make('card_preview')
                                    ->label('')
                                    ->content(function ($record): HtmlString|string {
                                        $imageUrl = $record?->display_image_url;

                                        if (! $imageUrl) {
                                            return '—';
                                        }

                                        return new HtmlString(
                                            '<div style="display: flex; justify-content: center; align-items: flex-start; width: 100%;">'
                                                .'<img src="'.e($imageUrl).'" alt="'.e($record->display_name).'" style="display: block; max-width: 100%; max-height: 500px; width: auto; height: auto; object-fit: contain;">'
                                                .'</div>'
                                        );
                                    }),
                            ])
                            ->columnSpan(5),
                    ])
                    ->columnSpanFull(),

                Section::make(__('admin.card_information'))
                    ->schema([
                        TextInput::make('api_local_id')
                            ->label(__('admin.local_id'))
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('api_category')
                            ->label(__('admin.category'))
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('api_illustrator')
                            ->label(__('admin.illustrator'))
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('api_rarity')
                            ->label(__('admin.rarity'))
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('api_hp')
                            ->label(__('admin.hp'))
                            ->numeric()
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('api_stage')
                            ->label(__('admin.stage'))
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('api_retreat')
                            ->label(__('admin.retreat_cost'))
                            ->numeric()
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('api_regulation_mark')
                            ->label(__('admin.regulation_mark'))
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make(__('admin.api_information'))
                    ->schema([
                        TextInput::make('external_id')
                            ->label(__('admin.external_id'))
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('api_name')
                            ->label(__('admin.api_name'))
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('api_image_url')
                            ->label(__('admin.api_image_url'))
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('api_evolve_from')
                            ->label(__('admin.evolve_from'))
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('api_level')
                            ->label(__('admin.level'))
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('api_trainer_type')
                            ->label(__('admin.trainer_type'))
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('api_energy_type')
                            ->label(__('admin.energy_type'))
                            ->disabled()
                            ->dehydrated(false),

                        Textarea::make('api_description')
                            ->label(__('admin.description'))
                            ->disabled()
                            ->dehydrated(false)
                            ->rows(3),

                        Textarea::make('api_effect')
                            ->label(__('admin.effect'))
                            ->disabled()
                            ->dehydrated(false)
                            ->rows(3),

                        Textarea::make('api_types')
                            ->label(__('admin.types'))
                            ->formatStateUsing(fn ($state): ?string => self::formatJson($state))
                            ->disabled()
                            ->dehydrated(false)
                            ->rows(2),

                        Textarea::make('api_dex_ids')
                            ->label(__('admin.dex_ids'))
                            ->formatStateUsing(fn ($state): ?string => self::formatJson($state))
                            ->disabled()
                            ->dehydrated(false)
                            ->rows(2),

                        Textarea::make('api_variants')
                            ->label(__('admin.variants'))
                            ->formatStateUsing(fn ($state): ?string => self::formatJson($state))
                            ->disabled()
                            ->dehydrated(false)
                            ->rows(3),

                        Textarea::make('api_variants_detailed')
                            ->label(__('admin.variants_detailed'))
                            ->formatStateUsing(fn ($state): ?string => self::formatJson($state))
                            ->disabled()
                            ->dehydrated(false)
                            ->rows(5),

                        Textarea::make('api_abilities')
                            ->label(__('admin.abilities'))
                            ->formatStateUsing(fn ($state): ?string => self::formatJson($state))
                            ->disabled()
                            ->dehydrated(false)
                            ->rows(4),

                        Textarea::make('api_attacks')
                            ->label(__('admin.attacks'))
                            ->formatStateUsing(fn ($state): ?string => self::formatJson($state))
                            ->disabled()
                            ->dehydrated(false)
                            ->rows(5),

                        Textarea::make('api_weaknesses')
                            ->label(__('admin.weaknesses'))
                            ->formatStateUsing(fn ($state): ?string => self::formatJson($state))
                            ->disabled()
                            ->dehydrated(false)
                            ->rows(3),

                        Textarea::make('api_resistances')
                            ->label(__('admin.resistances'))
                            ->formatStateUsing(fn ($state): ?string => self::formatJson($state))
                            ->disabled()
                            ->dehydrated(false)
                            ->rows(3),

                        Textarea::make('api_legal')
                            ->label(__('admin.legal_information'))
                            ->formatStateUsing(fn ($state): ?string => self::formatJson($state))
                            ->disabled()
                            ->dehydrated(false)
                            ->rows(2),

                        TextInput::make('api_updated_at')
                            ->label(__('admin.api_updated_at'))
                            ->disabled()
                            ->dehydrated(false),

                        Textarea::make('api_data')
                            ->label(__('admin.raw_api_data'))
                            ->formatStateUsing(fn ($state): ?string => self::formatJson($state))
                            ->disabled()
                            ->dehydrated(false)
                            ->rows(10),
                    ])
                    ->columns(2)
                    ->collapsed()
                    ->columnSpanFull(),

                Section::make(__('admin.current_prices'))
                    ->schema([
                        Placeholder::make('current_prices')
                            ->label(__('admin.current_prices'))
                            ->content(function ($record): string {
                                if (! $record) {
                                    return __('admin.no_price_information');
                                }

                                $record->loadMissing('prices');

                                if ($record->prices->isEmpty()) {
                                    return __('admin.no_price_information');
                                }

                                return $record->prices
                                    ->map(function ($price): string {
                                        $variant = $price->variant_key === 'card'
                                            ? __('admin.general')
                                            : trim(implode(' / ', array_filter([
                                                $price->variant_type,
                                                $price->variant_subtype,
                                            ])));

                                        $details = self::formatPriceData(
                                            $price->price_data ?? []
                                        );

                                        return implode(' | ', array_filter([
                                            ucfirst($price->source),
                                            $variant,
                                            $price->currency,
                                            $details,
                                        ]));
                                    })
                                    ->implode("\n");
                            }),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    protected static function formatJson(mixed $state): ?string
    {
        if ($state === null) {
            return null;
        }

        return is_array($state)
            ? json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
            : (string) $state;
    }

    protected static function formatPriceData(array $data): string
    {
        $values = [];

        foreach ($data as $key => $value) {
            if (in_array($key, ['idProduct', 'productId', 'updated', 'unit'], true)) {
                continue;
            }

            if (is_array($value)) {
                $nested = self::formatPriceData($value);

                if ($nested !== '') {
                    $values[] = $key.': '.$nested;
                }

                continue;
            }

            if (is_numeric($value)) {
                $values[] = $key.': '.number_format((float) $value, 2, '.', '');
            }
        }

        return implode(', ', $values);
    }
}