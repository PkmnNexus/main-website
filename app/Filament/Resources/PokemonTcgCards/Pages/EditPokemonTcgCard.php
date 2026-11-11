<?php

namespace App\Filament\Resources\PokemonTcgCards\Pages;

use App\Filament\Resources\PokemonTcgCards\PokemonTcgCardResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPokemonTcgCard extends EditRecord
{
    protected static string $resource = PokemonTcgCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
