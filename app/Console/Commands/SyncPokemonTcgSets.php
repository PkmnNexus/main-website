<?php

namespace App\Console\Commands;

use App\Services\PokemonTcg\PokemonTcgSetSync;
use Illuminate\Console\Command;
use Throwable;

class SyncPokemonTcgSets extends Command
{
    protected $signature = 'pokemon-tcg:sync-sets';

    protected $description = 'Synchronize Pokémon TCG sets from TCGdex';

    public function handle(PokemonTcgSetSync $sync): int
    {
        try {
            $syncRun = $sync->dispatch();

            $this->info('Pokémon TCG set synchronization dispatched successfully.');

            $this->table(
                ['Sync run', 'Total sets', 'Status'],
                [[
                    $syncRun->id,
                    $syncRun->total,
                    $syncRun->status,
                ]]
            );

            return self::SUCCESS;
        } catch (Throwable $exception) {
            report($exception);

            $this->error(
                'Pokémon TCG set synchronization failed: '.$exception->getMessage()
            );

            return self::FAILURE;
        }
    }
}