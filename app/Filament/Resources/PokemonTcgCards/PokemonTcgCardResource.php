<?php

namespace App\Filament\Resources\PokemonTcgCards;

use App\Filament\Resources\PokemonTcgCards\Pages\CreatePokemonTcgCard;
use App\Filament\Resources\PokemonTcgCards\Pages\EditPokemonTcgCard;
use App\Filament\Resources\PokemonTcgCards\Pages\ListPokemonTcgCards;
use App\Filament\Resources\PokemonTcgCards\Schemas\PokemonTcgCardForm;
use App\Filament\Resources\PokemonTcgCards\Tables\PokemonTcgCardsTable;
use App\Models\PokemonTcgCard;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PokemonTcgCardResource extends Resource
{
    protected static ?string $model = PokemonTcgCard::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'display_name';

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('admin.pokemon_tcg');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.cards');
    }

    public static function getModelLabel(): string
    {
        return __('admin.card');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.cards');
    }

    public static function getBreadcrumb(): string
    {
        return static::getNavigationLabel();
    }

    public static function form(Schema $schema): Schema
    {
        return PokemonTcgCardForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PokemonTcgCardsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPokemonTcgCards::route('/'),
            'create' => CreatePokemonTcgCard::route('/create'),
            'edit' => EditPokemonTcgCard::route('/{record}/edit'),
        ];
    }
}