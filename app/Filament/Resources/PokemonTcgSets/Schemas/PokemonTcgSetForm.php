<?php

namespace App\Filament\Resources\PokemonTcgSets\Schemas;

use App\Filament\Forms\Components\Media\AssetPicker;
use App\Models\PokemonTcgSeries;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PokemonTcgSetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin.general'))
                    ->schema([
                        Select::make('series_id')
                            ->label(__('admin.series'))
                            ->relationship('series', 'api_name')
                            ->getOptionLabelFromRecordUsing(fn (PokemonTcgSeries $record): string => $record->display_name)
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('name')
                            ->label(__('admin.name'))
                            ->maxLength(255)
                            ->nullable()
                            ->helperText(__('admin.pokemon_tcg_set_name_helper')),

                        AssetPicker::make('logo_asset_id')
                            ->label(__('admin.logo')),

                        AssetPicker::make('symbol_asset_id')
                            ->label(__('admin.symbol')),
                    ]),

                Section::make(__('admin.set_information'))
                    ->schema([
                        DatePicker::make('api_release_date')
                            ->label(__('admin.release_date'))
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('api_card_count_total')
                            ->label(__('admin.total_cards'))
                            ->numeric()
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('api_card_count_official')
                            ->label(__('admin.official_cards'))
                            ->numeric()
                            ->disabled()
                            ->dehydrated(false),
                    ]),

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

                        TextInput::make('api_logo_url')
                            ->label(__('admin.api_logo_url'))
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('api_symbol_url')
                            ->label(__('admin.api_symbol_url'))
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->collapsed(),
            ]);
    }
}