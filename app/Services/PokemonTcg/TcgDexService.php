<?php

namespace App\Services\PokemonTcg;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class TcgDexService
{
    protected string $baseUrl = 'https://api.tcgdex.net/v2/en';

    /*
    |--------------------------------------------------------------------------
    | Series
    |--------------------------------------------------------------------------
    */

    public function getSeries(): Collection
    {
        $response = Http::acceptJson()
            ->retry(3, 500)
            ->timeout(15)
            ->get("{$this->baseUrl}/series");

        return collect($response->throw()->json());
    }

    /*
    |--------------------------------------------------------------------------
    | Sets
    |--------------------------------------------------------------------------
    */

    public function getSets(): Collection
    {
        $response = Http::acceptJson()
            ->retry(3, 500)
            ->timeout(30)
            ->get("{$this->baseUrl}/sets");

        return collect($response->throw()->json());
    }

    public function getSet(string $id): array
    {
        $response = Http::acceptJson()
            ->retry(3, 500)
            ->timeout(30)
            ->get("{$this->baseUrl}/sets/".rawurlencode($id));

        return $response->throw()->json();
    }

    /*
    |--------------------------------------------------------------------------
    | Cards
    |--------------------------------------------------------------------------
    */

    /**
     * Get all card briefs from TCGdex.
     */
    public function getCards(): Collection
    {
        $response = Http::acceptJson()
            ->retry(3, 500)
            ->timeout(60)
            ->get("{$this->baseUrl}/cards");

        return collect($response->throw()->json());
    }

    /**
     * Get the complete information for one card.
     */
    public function getCard(string $id): array
    {
        $response = Http::acceptJson()
            ->retry(3, 500)
            ->timeout(30)
            ->get("{$this->baseUrl}/cards/".rawurlencode($id));

        return $response->throw()->json();
    }
}