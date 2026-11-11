<?php

namespace App\Filament\Resources\PokemonTcgSets;

use App\Filament\Resources\PokemonTcgSets\Pages\CreatePokemonTcgSet;
use App\Filament\Resources\PokemonTcgSets\Pages\EditPokemonTcgSet;
use App\Filament\Resources\PokemonTcgSets\Pages\ListPokemonTcgSets;
use App\Filament\Resources\PokemonTcgSets\Schemas\PokemonTcgSetForm;
use App\Filament\Resources\PokemonTcgSets\Tables\PokemonTcgSetsTable;
use App\Models\PokemonTcgSet;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PokemonTcgSetResource extends Resource
{
    protected static ?string $model = PokemonTcgSet::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'display_name';

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('admin.pokemon_tcg');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.sets');
    }

    public static function getModelLabel(): string
    {
        return __('admin.set');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.sets');
    }

    public static function getBreadcrumb(): string
    {
        return static::getNavigationLabel();
    }

    public static function form(Schema $schema): Schema
    {
        return PokemonTcgSetForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PokemonTcgSetsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPokemonTcgSets::route('/'),
            'create' => CreatePokemonTcgSet::route('/create'),
            'edit' => EditPokemonTcgSet::route('/{record}/edit'),
        ];
    }
}