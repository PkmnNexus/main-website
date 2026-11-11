<?php

namespace App\Console\Commands;

use App\Services\PokemonTcg\PokemonTcgSeriesSync;
use Illuminate\Console\Command;
use Throwable;

class SyncPokemonTcgSeries extends Command
{
    /*
    |--------------------------------------------------------------------------
    | Command Configuration
    |--------------------------------------------------------------------------
    */

    protected $signature = 'pokemon-tcg:sync-series';

    protected $description = 'Synchronize Pokémon TCG series from TCGdex.';

    /*
    |--------------------------------------------------------------------------
    | Execution
    |--------------------------------------------------------------------------
    */

    public function handle(PokemonTcgSeriesSync $sync): int
    {
        try {
            $syncRun = $sync->dispatch();

            $this->info('Pokémon TCG series synchronization dispatched successfully.');

            $this->newLine();

            $this->table(
                ['Sync run', 'Total series', 'Status'],
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
                'Pokémon TCG series synchronization failed: '.$exception->getMessage()
            );

            return self::FAILURE;
        }
    }
}