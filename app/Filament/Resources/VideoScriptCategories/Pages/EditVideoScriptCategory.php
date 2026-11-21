<?php

namespace App\Filament\Resources\VideoScriptCategories\Pages;

use App\Filament\Resources\VideoScriptCategories\VideoScriptCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVideoScriptCategory extends EditRecord
{
    protected static string $resource = VideoScriptCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
