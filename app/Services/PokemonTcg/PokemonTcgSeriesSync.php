<?php

namespace App\Services\PokemonTcg;

use App\Models\PokemonTcgSeries;
use Illuminate\Support\Facades\DB;

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
     * Synchronize all series from TCGdex.
     *
     * @return array{total: int, created: int, updated: int, skipped: int}
     */
    public function sync(): array
    {
        $series = $this->tcgDex->getSeries();

        return DB::transaction(function () use ($series) {
            $created = 0;
            $updated = 0;
            $skipped = 0;

            foreach ($series as $item) {
                if (empty($item['id']) || empty($item['name'])) {
                    $skipped++;

                    continue;
                }

                $model = PokemonTcgSeries::query()->firstOrNew([
                    'external_id' => $item['id'],
                ]);

                $isNew = ! $model->exists;

                $model->fill([
                    'api_name' => $item['name'],
                    'api_logo_url' => $item['logo'] ?? null,
                ]);

                $model->save();

                if ($isNew) {
                    $created++;
                } elseif ($model->wasChanged(['api_name', 'api_logo_url'])) {
                    $updated++;
                }
            }

            return [
                'total' => $series->count(),
                'created' => $created,
                'updated' => $updated,
                'skipped' => $skipped,
            ];
        });
    }
}