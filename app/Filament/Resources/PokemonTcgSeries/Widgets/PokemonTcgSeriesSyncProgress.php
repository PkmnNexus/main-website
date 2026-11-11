<?php

namespace App\Filament\Resources\PokemonTcgSeries\Widgets;

use App\Models\PokemonTcgSyncRun;
use Filament\Widgets\Widget;
use Livewire\Attributes\On;

class PokemonTcgSeriesSyncProgress extends Widget
{
    protected string $view = 'filament.resources.pokemon-tcg-series.widgets.pokemon-tcg-series-sync-progress';

    protected int|string|array $columnSpan = 'full';

    protected static bool $isLazy = false;

    public function getSyncRun(): ?PokemonTcgSyncRun
    {
        return PokemonTcgSyncRun::query()
            ->where('sync_type', 'series')
            ->latest('id')
            ->first();
    }

    public function getProgressPercentage(): int
    {
        $syncRun = $this->getSyncRun();

        if (! $syncRun || $syncRun->total === 0) {
            return 0;
        }

        return min(
            100,
            (int) round(($syncRun->processed / $syncRun->total) * 100)
        );
    }

    #[On('pokemon-tcg-series-sync-started')]
    public function refreshProgress(): void
    {
        //
    }
}