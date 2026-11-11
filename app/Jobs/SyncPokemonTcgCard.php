<?php

namespace App\Jobs;

use App\Models\PokemonTcgCard;
use App\Models\PokemonTcgSyncRun;
use App\Services\PokemonTcg\TcgDexService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Throwable;

class SyncPokemonTcgCard implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    public function __construct(
        public int $syncRunId,
        public string $externalId,
        public int $setId,
    ) {}

    public function handle(TcgDexService $tcgDex): void
    {
        PokemonTcgSyncRun::findOrFail($this->syncRunId);

        $cardData = $tcgDex->getCard($this->externalId);

        if (empty($cardData['id']) || empty($cardData['name'])) {
            $this->markProcessed('skipped');

            return;
        }

        $result = DB::transaction(function () use ($cardData) {
            $card = PokemonTcgCard::query()->firstOrNew([
                'external_id' => $cardData['id'],
            ]);

            $isNew = ! $card->exists;

            $card->fill([
                'set_id' => $this->setId,
                'api_local_id' => $cardData['localId'] ?? '',
                'api_name' => $cardData['name'],
                'api_image_url' => $cardData['image'] ?? null,
                'api_category' => $cardData['category'] ?? null,
                'api_illustrator' => $cardData['illustrator'] ?? null,
                'api_rarity' => $cardData['rarity'] ?? null,
                'api_hp' => $cardData['hp'] ?? null,
                'api_types' => $cardData['types'] ?? null,
                'api_dex_ids' => $cardData['dexId'] ?? null,
                'api_evolve_from' => $cardData['evolveFrom'] ?? null,
                'api_description' => $cardData['description'] ?? null,
                'api_level' => $cardData['level'] ?? null,
                'api_stage' => $cardData['stage'] ?? null,
                'api_suffix' => $cardData['suffix'] ?? null,
                'api_trainer_type' => $cardData['trainerType'] ?? null,
                'api_energy_type' => $cardData['energyType'] ?? null,
                'api_effect' => $cardData['effect'] ?? null,
                'api_retreat' => $cardData['retreat'] ?? null,
                'api_regulation_mark' => $cardData['regulationMark'] ?? null,
                'api_variants' => $cardData['variants'] ?? null,
                'api_variants_detailed' => $cardData['variants_detailed'] ?? null,
                'api_abilities' => $cardData['abilities'] ?? null,
                'api_attacks' => $cardData['attacks'] ?? null,
                'api_weaknesses' => $cardData['weaknesses'] ?? null,
                'api_resistances' => $cardData['resistances'] ?? null,
                'api_legal' => $cardData['legal'] ?? null,
                'api_updated_at' => $cardData['updated'] ?? null,
                'api_data' => $cardData,
            ]);

            $card->save();

            $pricesChanged = $this->syncPrices($card, $cardData);

            if ($isNew) {
                return 'created';
            }

            if ($card->wasChanged() || $pricesChanged) {
                return 'updated';
            }

            return 'none';
        });

        $this->markProcessed($result);
    }

    protected function syncPrices(
        PokemonTcgCard $card,
        array $cardData
    ): bool {
        $pricesChanged = false;

        /*
        |--------------------------------------------------------------------------
        | General Card Prices
        |--------------------------------------------------------------------------
        */

        if (! empty($cardData['pricing']) && is_array($cardData['pricing'])) {
            $pricesChanged = $this->syncPriceSources(
                $card,
                $cardData['pricing'],
                'card'
            ) || $pricesChanged;
        }

        /*
        |--------------------------------------------------------------------------
        | Detailed Variant Prices
        |--------------------------------------------------------------------------
        */

        foreach ($cardData['variants_detailed'] ?? [] as $index => $variant) {
            if (empty($variant['pricing']) || ! is_array($variant['pricing'])) {
                continue;
            }

            $variantKey = $variant['variantId']
                ?? 'variant-'.$index;

            $pricesChanged = $this->syncPriceSources(
                $card,
                $variant['pricing'],
                (string) $variantKey,
                $variant
            ) || $pricesChanged;
        }

        return $pricesChanged;
    }

    protected function syncPriceSources(
        PokemonTcgCard $card,
        array $pricing,
        string $variantKey,
        array $variant = []
    ): bool {
        $pricesChanged = false;

        foreach (['cardmarket', 'tcgplayer'] as $source) {
            $sourcePricing = $pricing[$source] ?? null;

            if (! is_array($sourcePricing)) {
                continue;
            }

            $externalProductId = $sourcePricing['idProduct']
                ?? $this->findProductId($sourcePricing);

            if (
                $externalProductId === null
                && isset($variant['thirdParty'][$source])
            ) {
                $externalProductId = $variant['thirdParty'][$source];
            }

            $price = $card->prices()->updateOrCreate(
                [
                    'variant_key' => $variantKey,
                    'source' => $source,
                ],
                [
                    'variant_type' => $variant['type'] ?? null,
                    'variant_subtype' => $variant['subtype'] ?? null,
                    'variant_data' => $this->getVariantData($variant),
                    'currency' => $sourcePricing['unit'] ?? null,
                    'external_product_id' => $externalProductId !== null
                        ? (string) $externalProductId
                        : null,
                    'price_data' => $sourcePricing,
                    'source_updated_at' => $sourcePricing['updated'] ?? null,
                ]
            );

            if ($price->wasRecentlyCreated || $price->wasChanged()) {
                $pricesChanged = true;
            }
        }

        return $pricesChanged;
    }

    protected function getVariantData(array $variant): ?array
    {
        if ($variant === []) {
            return null;
        }

        unset($variant['pricing']);

        return $variant;
    }

    protected function findProductId(array $pricing): int|string|null
    {
        foreach ($pricing as $value) {
            if (
                is_array($value)
                && isset($value['productId'])
            ) {
                return $value['productId'];
            }
        }

        return null;
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