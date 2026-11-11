<?php

namespace App\Console\Commands;

use App\Services\PokemonTcg\PokemonTcgCardSync;
use Illuminate\Console\Command;
use Throwable;

class SyncPokemonTcgCards extends Command
{
    protected $signature = 'pokemon-tcg:sync-cards';

    protected $description = 'Synchronize Pokémon TCG cards from TCGdex';

    public function handle(PokemonTcgCardSync $sync): int
    {
        try {
            $syncRun = $sync->dispatch();

            $this->info('Pokémon TCG card synchronization dispatched successfully.');

            $this->table(
                ['Sync run', 'Total cards', 'Status'],
                [[
                    $syncRun->id,
                    $syncRun->total,
                    $syncRun->status,
                ]]
            );

            return self::SUCCESS;
        } catch (Throwable $exception) {
            report($exception);

            $this->error('Pokémon TCG card synchronization failed.');
            $this->error($exception->getMessage());

            return self::FAILURE;
        }
    }
}