<?php

namespace App\Jobs;

use App\Models\PokemonTcgSeries;
use App\Models\PokemonTcgSyncRun;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Throwable;

class SyncPokemonTcgSeries implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    public function __construct(
        public int $syncRunId,
        public array $seriesData,
    ) {}

    public function handle(): void
    {
        PokemonTcgSyncRun::findOrFail($this->syncRunId);

        if (
            empty($this->seriesData['id'])
            || empty($this->seriesData['name'])
        ) {
            $this->markProcessed('skipped');

            return;
        }

        $series = PokemonTcgSeries::query()->firstOrNew([
            'external_id' => $this->seriesData['id'],
        ]);

        $isNew = ! $series->exists;

        $series->fill([
            'api_name' => $this->seriesData['name'],
            'api_logo_url' => $this->seriesData['logo'] ?? null,
        ]);

        $series->save();

        $result = 'none';

        if ($isNew) {
            $result = 'created';
        } elseif ($series->wasChanged([
            'api_name',
            'api_logo_url',
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