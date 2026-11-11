<?php

namespace App\Filament\Resources\PokemonTcgSeries\Schemas;

use App\Filament\Forms\Components\Media\AssetPicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PokemonTcgSeriesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin.general'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('admin.name'))
                            ->maxLength(255)
                            ->nullable()
                            ->helperText(__('admin.pokemon_tcg_series_name_helper')),

                        AssetPicker::make('logo_asset_id')
                            ->label(__('admin.logo')),
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
                    ])
                    ->collapsed(),
            ]);
    }
}