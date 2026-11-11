<?php

namespace App\Services\PokemonTcg;

use App\Jobs\SyncPokemonTcgSeries;
use App\Models\PokemonTcgSyncRun;
use Illuminate\Support\Facades\DB;
use Throwable;

class PokemonTcgSeriesSync
{
    public function __construct(
        protected TcgDexService $tcgDex
    ) {}

    /*
    |--------------------------------------------------------------------------
    | Synchronization
    |--------------------------------------------------------------------------
    */

    /**
     * Dispatch all series synchronization jobs.
     */
    public function dispatch(): PokemonTcgSyncRun
    {
        $series = $this->tcgDex->getSeries();

        $seriesItems = $series->values();

        $syncRun = DB::transaction(function () use ($seriesItems) {
            return PokemonTcgSyncRun::create([
                'sync_type' => 'series',
                'status' => $seriesItems->isEmpty() ? 'completed' : 'running',
                'total' => $seriesItems->count(),
                'started_at' => now(),
                'completed_at' => $seriesItems->isEmpty() ? now() : null,
            ]);
        });

        if ($seriesItems->isEmpty()) {
            return $syncRun;
        }

        try {
            foreach ($seriesItems as $item) {
                SyncPokemonTcgSeries::dispatch(
                    $syncRun->id,
                    (array) $item
                );
            }
        } catch (Throwable $exception) {
            $syncRun->update([
                'status' => 'failed',
                'error_message' => $exception->getMessage(),
                'completed_at' => now(),
            ]);

            throw $exception;
        }

        return $syncRun->fresh();
    }
}