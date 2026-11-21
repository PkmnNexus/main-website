<?php

namespace App\Filament\Resources\VideoScripts\Pages;

use App\Filament\Resources\VideoScripts\VideoScriptResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVideoScripts extends ListRecords
{
    protected static string $resource = VideoScriptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
