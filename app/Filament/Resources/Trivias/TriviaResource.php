<?php

namespace App\Filament\Resources\Trivias;

use App\Filament\Resources\Trivias\Pages\CreateTrivia;
use App\Filament\Resources\Trivias\Pages\EditTrivia;
use App\Filament\Resources\Trivias\Pages\ListTrivias;
use App\Filament\Resources\Trivias\Schemas\TriviaForm;
use App\Filament\Resources\Trivias\Tables\TriviasTable;
use App\Models\Trivia;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TriviaResource extends Resource
{
    protected static ?string $model = Trivia::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLightBulb;

    protected static string|UnitEnum|null $navigationGroup = null;

    protected static ?string $navigationLabel = null;

    protected static ?int $navigationSort = 5;

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('admin.posts');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.trivia');
    }

    public static function getBreadcrumb(): string
    {
        return static::getNavigationLabel();
    }

    public static function form(Schema $schema): Schema
    {
        return TriviaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TriviasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTrivias::route('/'),
            'create' => CreateTrivia::route('/create'),
            'edit' => EditTrivia::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 0 ? 'primary' : 'gray';
    }
}