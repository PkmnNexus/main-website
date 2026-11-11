<?php

namespace App\Filament\Resources\PokemonTcgSeries\Pages;

use App\Filament\Resources\PokemonTcgSeries\PokemonTcgSeriesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPokemonTcgSeries extends EditRecord
{
    protected static string $resource = PokemonTcgSeriesResource::class;

    public function getTitle(): string
    {
        return __('admin.series');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
