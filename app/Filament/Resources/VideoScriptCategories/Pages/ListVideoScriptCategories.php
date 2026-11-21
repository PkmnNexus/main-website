<?php

namespace App\Filament\Resources\VideoScriptCategories\Pages;

use App\Filament\Resources\VideoScriptCategories\VideoScriptCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVideoScriptCategories extends ListRecords
{
    protected static string $resource = VideoScriptCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
