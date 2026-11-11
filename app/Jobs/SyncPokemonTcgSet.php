<?php

namespace App\Jobs;

use App\Models\PokemonTcgSeries;
use App\Models\PokemonTcgSet;
use App\Models\PokemonTcgSyncRun;
use App\Services\PokemonTcg\TcgDexService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Throwable;

class SyncPokemonTcgSet implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    public function __construct(
        public int $syncRunId,
        public string $externalId,
    ) {}

    public function handle(TcgDexService $tcgDex): void
    {
        $syncRun = PokemonTcgSyncRun::findOrFail($this->syncRunId);

        $details = $tcgDex->getSet($this->externalId);

        if (
            empty($details['id'])
            || empty($details['serie']['id'])
            || empty($details['name'])
        ) {
            $this->markProcessed('skipped');

            return;
        }

        $series = PokemonTcgSeries::query()
            ->where('external_id', $details['serie']['id'])
            ->first();

        if (! $series) {
            $this->markProcessed('skipped');

            return;
        }

        $set = PokemonTcgSet::query()->firstOrNew([
            'external_id' => $details['id'],
        ]);

        $isNew = ! $set->exists;

        $set->fill([
            'series_id' => $series->id,
            'api_name' => $details['name'],
            'api_logo_url' => $details['logo'] ?? null,
            'api_symbol_url' => $details['symbol'] ?? null,
            'api_release_date' => $details['releaseDate'] ?? null,
            'api_card_count_total' => $details['cardCount']['total'] ?? null,
            'api_card_count_official' => $details['cardCount']['official'] ?? null,
        ]);

        $set->save();

        $result = 'none';

        if ($isNew) {
            $result = 'created';
        } elseif ($set->wasChanged([
            'series_id',
            'api_name',
            'api_logo_url',
            'api_symbol_url',
            'api_release_date',
            'api_card_count_total',
            'api_card_count_official',
        ])) {
            $result = 'updated';
        }

        $this->markProcessed($result);
    }

    protected function markProcessed(string $result): void
    {
        DB::transaction(function () use ($result) {
            $syncRun = PokemonTcgSyncRun::query()
                ->lockForUpdate()
                ->findOrFail($this->syncRunId);

            $syncRun->increment('processed');

            if (in_array($result, ['created', 'updated', 'skipped', 'failed'], true)) {
                $syncRun->increment($result);
            }

            if ($syncRun->fresh()->processed >= $syncRun->total) {
                $syncRun->update([
                    'status' => 'completed',
                    'completed_at' => now(),
                ]);
            }
        });
    }

    public function failed(?Throwable $exception): void
    {
        $this->markProcessed('failed');

        PokemonTcgSyncRun::query()
            ->whereKey($this->syncRunId)
            ->update([
                'error_message' => $exception?->getMessage(),
            ]);
    }
}