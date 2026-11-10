<?php

namespace Database\Seeders;

use App\Models\Trivia;
use Illuminate\Database\Seeder;

class TriviaSeeder extends Seeder
{
    public function run(): void
    {
        $trivias = [
            [
                'fact' => [
                    'en' => 'Pikachu stores electricity in the electric sacs on its cheeks.',
                    'nl' => 'Pikachu bewaart elektriciteit in de elektrische zakjes in zijn wangen.',
                ],
                'sort_order' => 1,
            ],
            [
                'fact' => [
                    'en' => 'Bulbasaur carries a seed on its back from the moment it is born.',
                    'nl' => 'Bulbasaur draagt vanaf zijn geboorte een zaadje op zijn rug.',
                ],
                'sort_order' => 2,
            ],
            [
                'fact' => [
                    'en' => 'The flame on Charmander’s tail indicates its life force.',
                    'nl' => 'De vlam op Charmanders staart geeft zijn levenskracht aan.',
                ],
                'sort_order' => 3,
            ],
        ];

        foreach ($trivias as $data) {
            $trivia = Trivia::query()
                ->where('fact->en', $data['fact']['en'])
                ->first();

            if ($trivia) {
                $trivia->update([
                    'fact' => $data['fact'],
                    'sort_order' => $data['sort_order'],
                ]);

                continue;
            }

            Trivia::query()->create([
                ...$data,
                'is_active' => true,
            ]);
        }
    }
}
