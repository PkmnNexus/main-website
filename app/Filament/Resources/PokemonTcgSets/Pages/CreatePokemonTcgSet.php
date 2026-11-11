<?php

namespace App\Filament\Resources\PokemonTcgSets\Pages;

use App\Filament\Resources\PokemonTcgSets\PokemonTcgSetResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePokemonTcgSet extends CreateRecord
{
    protected static string $resource = PokemonTcgSetResource::class;

    public function getTitle(): string
    {
        return __('admin.set');
    }
}