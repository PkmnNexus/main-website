<?php

namespace App\Filament\Resources\PokemonTcgSeries\Pages;

use App\Filament\Resources\PokemonTcgSeries\PokemonTcgSeriesResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePokemonTcgSeries extends CreateRecord
{
    protected static string $resource = PokemonTcgSeriesResource::class;

    public function getTitle(): string
    {
        return __('admin.series');
    }
}