<?php

namespace App\Filament\Resources\VideoScripts;

use App\Filament\Resources\VideoScripts\Pages\CreateVideoScript;
use App\Filament\Resources\VideoScripts\Pages\EditVideoScript;
use App\Filament\Resources\VideoScripts\Pages\ListVideoScripts;
use App\Filament\Resources\VideoScripts\Schemas\VideoScriptForm;
use App\Filament\Resources\VideoScripts\Tables\VideoScriptsTable;
use App\Models\VideoScript;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VideoScriptResource extends Resource
{
    protected static ?string $model = VideoScript::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = null;

    protected static ?string $navigationLabel = null;

    protected static ?int $navigationSort = -7;

    protected static ?string $recordTitleAttribute = 'title';

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('admin.video_scripts');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.video_script');
    }

    public static function getBreadcrumb(): string
    {
        return static::getNavigationLabel();
    }

    public static function getTitle(): string
    {
        return static::getNavigationLabel();
    }

    public static function form(Schema $schema): Schema
    {
        return VideoScriptForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VideoScriptsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVideoScripts::route('/'),
            'create' => CreateVideoScript::route('/create'),
            'edit' => EditVideoScript::route('/{record}/edit'),
        ];
    }
}