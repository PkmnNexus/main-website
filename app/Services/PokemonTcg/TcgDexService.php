<?php

namespace App\Services\PokemonTcg;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class TcgDexService
{
    protected string $baseUrl = 'https://api.tcgdex.net/v2/en';

    public function getSeries(): Collection
    {
        $response = Http::acceptJson()
            ->retry(3, 500)
            ->timeout(15)
            ->get("{$this->baseUrl}/series");

        return collect($response->throw()->json());
    }

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
            ->timeout(15)
            ->get("{$this->baseUrl}/sets/{$id}");

        return $response->throw()->json();
    }
}