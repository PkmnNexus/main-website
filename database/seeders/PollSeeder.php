<?php

namespace Database\Seeders;

use App\Models\Poll;
use Illuminate\Database\Seeder;

class PollSeeder extends Seeder
{
    public function run(): void
    {
        $poll = Poll::create([
            'question' => [
                'en' => 'Which Pokémon starter is your favourite?',
                'nl' => 'Welke Pokémon-starter is jouw favoriet?',
            ],

            'description' => [
                'en' => 'Choose your favourite starter Pokémon!',
                'nl' => 'Kies jouw favoriete starter-Pokémon!',
            ],

            'is_active' => true,
            'show_results_before_vote' => false,

            'starts_at' => now(),
            'ends_at' => now()->addDays(30),
        ]);

        $options = [
            [
                'en' => 'Bulbasaur',
                'nl' => 'Bulbasaur',
            ],
            [
                'en' => 'Charmander',
                'nl' => 'Charmander',
            ],
            [
                'en' => 'Squirtle',
                'nl' => 'Squirtle',
            ],
        ];

        foreach ($options as $index => $label) {
            $poll->options()->create([
                'label' => $label,
                'sort_order' => $index,
            ]);
        }
    }
}