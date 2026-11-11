<?php

namespace App\Filament\Resources\PokemonTcgSets\Widgets;

use App\Models\PokemonTcgSyncRun;
use Filament\Widgets\Widget;
use Livewire\Attributes\On;

class PokemonTcgSetSyncProgress extends Widget
{
    protected string $view = 'filament.resources.pokemon-tcg-sets.widgets.pokemon-tcg-set-sync-progress';

    protected int|string|array $columnSpan = 'full';

    protected static bool $isLazy = false;

    public function getSyncRun(): ?PokemonTcgSyncRun
    {
        return PokemonTcgSyncRun::query()
            ->where('sync_type', 'sets')
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

    #[On('pokemon-tcg-set-sync-started')]
    public function refreshProgress(): void
    {
        //
    }
}