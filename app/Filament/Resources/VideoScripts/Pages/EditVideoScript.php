<?php

namespace App\Filament\Resources\VideoScripts\Pages;

use App\Filament\Resources\VideoScripts\VideoScriptResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVideoScript extends EditRecord
{
    protected static string $resource = VideoScriptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
