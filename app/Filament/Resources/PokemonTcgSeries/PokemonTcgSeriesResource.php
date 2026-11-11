<?php

namespace App\Filament\Resources\PokemonTcgSeries;

use App\Filament\Resources\PokemonTcgSeries\Pages\CreatePokemonTcgSeries;
use App\Filament\Resources\PokemonTcgSeries\Pages\EditPokemonTcgSeries;
use App\Filament\Resources\PokemonTcgSeries\Pages\ListPokemonTcgSeries;
use App\Filament\Resources\PokemonTcgSeries\Schemas\PokemonTcgSeriesForm;
use App\Filament\Resources\PokemonTcgSeries\Tables\PokemonTcgSeriesTable;
use App\Models\PokemonTcgSeries;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PokemonTcgSeriesResource extends Resource
{
    protected static ?string $model = PokemonTcgSeries::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = null;

    protected static ?string $navigationLabel = null;

    protected static ?string $modelLabel = null;

    protected static ?string $pluralModelLabel = null;

    protected static ?int $navigationSort = null;

    protected static ?string $recordTitleAttribute = 'display_name';

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('admin.pokemon_tcg');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.series');
    }

    public static function getModelLabel(): string
    {
        return __('admin.series');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.series');
    }

    public static function getBreadcrumb(): string
    {
        return static::getNavigationLabel();
    }

    public static function form(Schema $schema): Schema
    {
        return PokemonTcgSeriesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PokemonTcgSeriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPokemonTcgSeries::route('/'),
            'create' => CreatePokemonTcgSeries::route('/create'),
            'edit' => EditPokemonTcgSeries::route('/{record}/edit'),
        ];
    }
}