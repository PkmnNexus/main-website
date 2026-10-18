<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Pokémon Core
            [
                'name' => 'News',
                'description' => 'General Pokémon news and announcements.',
            ],
            [
                'name' => 'Games',
                'description' => 'News, features, and updates about Pokémon games.',
            ],
            [
                'name' => 'Pokémon Championship',
                'description' => 'Coverage of Pokémon events, tournaments, and special occasions.',
            ],
            [
                'name' => 'Pokémon Day',
                'description' => 'Updates, patches, announcements, and changes across Pokémon games and services.',
            ],

            // Pokémon Sub-franchises
            [
                'name' => 'Pokémon GO',
                'description' => 'News, updates, events, raids, and guides for Pokémon GO.',
            ],
            [
                'name' => 'Pokémon TCG',
                'description' => 'News, sets, cards, products, and updates about the Pokémon Trading Card Game.',
            ],
            [
                'name' => 'Pokémon TCG Pocket',
                'description' => 'News, updates, cards, events, and guides for Pokémon Trading Card Game Pocket.',
            ],
            [
                'name' => 'Pokémon Anime',
                'description' => 'News, episodes, characters, and updates about the Pokémon anime.',
            ],
            [
                'name' => 'Pokémon Sleep',
                'description' => 'News, episodes, characters, and updates about the Pokémon anime.',
            ],
            [
                'name' => 'Pokémon Center',
                'description' => 'News, episodes, characters, and updates about the Pokémon anime.',
            ],

            // Content types (SEO structuur)
            [
                'name' => 'Reviews',
                'description' => 'Reviews and evaluations of Pokémon games, products, cards, and related content.',
            ],
            [
                'name' => 'Rumours and Leaks',
                'description' => 'Reported leaks and leaked information related to Pokémon and Nintendo.',
            ],
            [
                'name' => 'Deep Dive',
                'description' => 'In-depth analysis and detailed explorations of Pokémon and related topics.',
            ],
            [
                'name' => 'Card Gallery',
                'description' => 'Card galleries featuring Pokémon Trading Card Game cards and collections.',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                [
                    'slug' => Str::slug($category['name']),
                ],
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                ]
            );
        }
    }
}
