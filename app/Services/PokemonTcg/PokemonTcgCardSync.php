<?php

namespace App\Services\PokemonTcg;

use App\Jobs\SyncPokemonTcgCard;
use App\Models\PokemonTcgSet;
use App\Models\PokemonTcgSyncRun;
use Illuminate\Support\Facades\DB;
use Throwable;

class PokemonTcgCardSync
{
    public function __construct(
        protected TcgDexService $tcgDex
    ) {}

    public function dispatch(): PokemonTcgSyncRun
    {
        $cards = $this->tcgDex->getCards();

        $sets = PokemonTcgSet::query()
            ->pluck('id', 'external_id');

        $cardJobs = [];

        foreach ($cards as $item) {
            $item = (array) $item;

            $externalId = $item['id'] ?? null;
            $localId = $item['localId'] ?? null;

            if (
                ! is_string($externalId)
                || ! is_string($localId)
                || $externalId === ''
                || $localId === ''
                || ! str_ends_with($externalId, '-'.$localId)
            ) {
                continue;
            }

            $setExternalId = substr(
                $externalId,
                0,
                -strlen($localId) - 1
            );

            $setId = $sets->get($setExternalId);

            if (! $setId) {
                continue;
            }

            $cardJobs[$externalId] = [
                'set_id' => (int) $setId,
            ];
        }

        return $this->dispatchCardJobs($cardJobs);
    }

    public function dispatchSet(PokemonTcgSet $set): PokemonTcgSyncRun
    {
        $cards = $this->tcgDex->getCards();

        $cardJobs = [];

        foreach ($cards as $item) {
            $item = (array) $item;

            $externalId = $item['id'] ?? null;
            $localId = $item['localId'] ?? null;

            if (
                ! is_string($externalId)
                || ! is_string($localId)
                || $externalId === ''
                || $localId === ''
                || ! str_ends_with($externalId, '-'.$localId)
            ) {
                continue;
            }

            $setExternalId = substr(
                $externalId,
                0,
                -strlen($localId) - 1
            );

            if ($setExternalId !== $set->external_id) {
                continue;
            }

            $cardJobs[$externalId] = [
                'set_id' => $set->id,
            ];
        }

        return $this->dispatchCardJobs($cardJobs);
    }

    protected function dispatchCardJobs(array $cardJobs): PokemonTcgSyncRun
    {
        $total = count($cardJobs);

        $syncRun = DB::transaction(function () use ($total) {
            return PokemonTcgSyncRun::create([
                'sync_type' => 'cards',
                'status' => $total === 0 ? 'completed' : 'running',
                'total' => $total,
                'started_at' => now(),
                'completed_at' => $total === 0 ? now() : null,
            ]);
        });

        if ($total === 0) {
            return $syncRun;
        }

        try {
            foreach ($cardJobs as $externalId => $data) {
                SyncPokemonTcgCard::dispatch(
                    $syncRun->id,
                    $externalId,
                    $data['set_id']
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