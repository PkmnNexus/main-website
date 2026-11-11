<?php

namespace App\Filament\Resources\PokemonTcgCards\Pages;

use App\Filament\Resources\PokemonTcgCards\PokemonTcgCardResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePokemonTcgCard extends CreateRecord
{
    protected static string $resource = PokemonTcgCardResource::class;
}
