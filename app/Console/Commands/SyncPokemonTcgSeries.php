<?php

namespace App\Console\Commands;

use App\Services\PokemonTcg\PokemonTcgSeriesSync;
use Illuminate\Console\Command;

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
        $this->info('Synchronizing Pokémon TCG series...');

        $result = $sync->sync();

        $this->newLine();

        $this->info('Series synchronization completed.');

        $this->table(
            ['Total', 'Created', 'Updated', 'Skipped'],
            [[
                $result['total'],
                $result['created'],
                $result['updated'],
                $result['skipped'],
            ]]
        );

        return self::SUCCESS;
    }
}