<?php

namespace App\Filament\Resources\VideoScriptCategories;

use App\Filament\Resources\VideoScriptCategories\Pages\CreateVideoScriptCategory;
use App\Filament\Resources\VideoScriptCategories\Pages\EditVideoScriptCategory;
use App\Filament\Resources\VideoScriptCategories\Pages\ListVideoScriptCategories;
use App\Filament\Resources\VideoScriptCategories\Schemas\VideoScriptCategoryForm;
use App\Filament\Resources\VideoScriptCategories\Tables\VideoScriptCategoriesTable;
use App\Models\VideoScriptCategory;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VideoScriptCategoryResource extends Resource
{
    protected static ?string $model = VideoScriptCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static string|UnitEnum|null $navigationGroup = null;

    protected static ?string $navigationLabel = null;

    protected static ?int $navigationSort = -6;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('admin.video_scripts');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.video_categories');
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
        return VideoScriptCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VideoScriptCategoriesTable::configure($table);
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
            'index' => ListVideoScriptCategories::route('/'),
            'create' => CreateVideoScriptCategory::route('/create'),
            'edit' => EditVideoScriptCategory::route('/{record}/edit'),
        ];
    }
}