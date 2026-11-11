<?php

namespace App\Services\PokemonTcg;

use App\Jobs\SyncPokemonTcgSet;
use App\Models\PokemonTcgSet;
use App\Models\PokemonTcgSyncRun;
use Illuminate\Support\Facades\DB;
use Throwable;

class PokemonTcgSetSync
{
    public function __construct(
        protected TcgDexService $tcgDex
    ) {}

    public function dispatch(): PokemonTcgSyncRun
    {
        $sets = $this->tcgDex->getSets();

        $setIds = $sets
            ->pluck('id')
            ->filter()
            ->unique()
            ->values();

        $syncRun = DB::transaction(function () use ($setIds) {
            return PokemonTcgSyncRun::create([
                'sync_type' => 'sets',
                'status' => $setIds->isEmpty() ? 'completed' : 'running',
                'total' => $setIds->count(),
                'started_at' => now(),
                'completed_at' => $setIds->isEmpty() ? now() : null,
            ]);
        });

        if ($setIds->isEmpty()) {
            return $syncRun;
        }

        try {
            foreach ($setIds as $setId) {
                SyncPokemonTcgSet::dispatch(
                    $syncRun->id,
                    (string) $setId
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

    public function dispatchSet(PokemonTcgSet $set): PokemonTcgSyncRun
    {
        $syncRun = DB::transaction(function () {
            return PokemonTcgSyncRun::create([
                'sync_type' => 'sets',
                'status' => 'running',
                'total' => 1,
                'started_at' => now(),
            ]);
        });

        try {
            SyncPokemonTcgSet::dispatch(
                $syncRun->id,
                $set->external_id
            );
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