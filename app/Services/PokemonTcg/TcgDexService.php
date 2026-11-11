<?php

namespace App\Services\PokemonTcg;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class TcgDexService
{
    /*
    |--------------------------------------------------------------------------
    | API Configuration
    |--------------------------------------------------------------------------
    */

    protected string $baseUrl = 'https://api.tcgdex.net/v2/en';

    /*
    |--------------------------------------------------------------------------
    | Series
    |--------------------------------------------------------------------------
    */

    /**
     * Retrieve all series from TCGdex.
     */
    public function getSeries(): Collection
    {
        $response = Http::acceptJson()
            ->timeout(15)
            ->get("{$this->baseUrl}/series");

        return collect($response->throw()->json());
    }
}
