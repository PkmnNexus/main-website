<?php

namespace App\Filament\Resources\PokemonTcgCards\Widgets;

use App\Models\PokemonTcgSyncRun;
use Filament\Widgets\Widget;
use Livewire\Attributes\On;

class PokemonTcgCardSyncProgress extends Widget
{
    protected string $view = 'filament.resources.pokemon-tcg-cards.widgets.pokemon-tcg-card-sync-progress';

    protected int|string|array $columnSpan = 'full';

    protected static bool $isLazy = false;

    public function getSyncRun(): ?PokemonTcgSyncRun
    {
        return PokemonTcgSyncRun::query()
            ->where('sync_type', 'cards')
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

    #[On('pokemon-tcg-card-sync-started')]
    public function refreshProgress(): void {}
}