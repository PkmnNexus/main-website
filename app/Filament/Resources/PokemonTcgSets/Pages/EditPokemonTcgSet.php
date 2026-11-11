<?php

namespace App\Filament\Resources\PokemonTcgSets\Pages;

use App\Filament\Resources\PokemonTcgSets\PokemonTcgSetResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPokemonTcgSet extends EditRecord
{
    protected static string $resource = PokemonTcgSetResource::class;

    public function getTitle(): string
    {
        return __('admin.set');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}