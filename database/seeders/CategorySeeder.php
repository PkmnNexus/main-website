<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
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
                'key' => 'news',
                'name' => [
                    'nl' => 'Nieuws',
                    'en' => 'News',
                ],
                'description' => [
                    'nl' => 'Algemeen Pokémon-nieuws en aankondigingen.',
                    'en' => 'General Pokémon news and announcements.',
                ],
            ],
            [
                'key' => 'games',
                'name' => [
                    'nl' => 'Games',
                    'en' => 'Games',
                ],
                'description' => [
                    'nl' => 'Nieuws, features en updates over Pokémon-games.',
                    'en' => 'News, features, and updates about Pokémon games.',
                ],
            ],
            [
                'key' => 'pokemon-championship',
                'name' => [
                    'nl' => 'Pokémon-kampioenschap',
                    'en' => 'Pokémon Championship',
                ],
                'description' => [
                    'nl' => 'Verslaggeving over Pokémon-evenementen, toernooien en speciale gelegenheden.',
                    'en' => 'Coverage of Pokémon events, tournaments, and special occasions.',
                ],
            ],
            [
                'key' => 'pokemon-day',
                'name' => [
                    'nl' => 'Pokémon Day',
                    'en' => 'Pokémon Day',
                ],
                'description' => [
                    'nl' => 'Updates, patches, aankondigingen en wijzigingen in Pokémon-games en -diensten.',
                    'en' => 'Updates, patches, announcements, and changes across Pokémon games and services.',
                ],
            ],

            // Pokémon Sub-franchises
            [
                'key' => 'pokemon-go',
                'name' => [
                    'nl' => 'Pokémon GO',
                    'en' => 'Pokémon GO',
                ],
                'description' => [
                    'nl' => 'Nieuws, updates, evenementen, raids en gidsen voor Pokémon GO.',
                    'en' => 'News, updates, events, raids, and guides for Pokémon GO.',
                ],
            ],
            [
                'key' => 'pokemon-tcg',
                'name' => [
                    'nl' => 'Pokémon TCG',
                    'en' => 'Pokémon TCG',
                ],
                'description' => [
                    'nl' => 'Nieuws, sets, kaarten, producten en updates over de Pokémon Trading Card Game.',
                    'en' => 'News, sets, cards, products, and updates about the Pokémon Trading Card Game.',
                ],
            ],
            [
                'key' => 'pokemon-tcg-pocket',
                'name' => [
                    'nl' => 'Pokémon TCG Pocket',
                    'en' => 'Pokémon TCG Pocket',
                ],
                'description' => [
                    'nl' => 'Nieuws, updates, kaarten, evenementen en gidsen voor Pokémon Trading Card Game Pocket.',
                    'en' => 'News, updates, cards, events, and guides for Pokémon Trading Card Game Pocket.',
                ],
            ],
            [
                'key' => 'pokemon-anime',
                'name' => [
                    'nl' => 'Pokémon-anime',
                    'en' => 'Pokémon Anime',
                ],
                'description' => [
                    'nl' => 'Nieuws, afleveringen, personages en updates over de Pokémon-anime.',
                    'en' => 'News, episodes, characters, and updates about the Pokémon anime.',
                ],
            ],
            [
                'key' => 'pokemon-sleep',
                'name' => [
                    'nl' => 'Pokémon Sleep',
                    'en' => 'Pokémon Sleep',
                ],
                'description' => [
                    'nl' => 'Nieuws, updates, evenementen en gidsen voor Pokémon Sleep.',
                    'en' => 'News, updates, events, and guides for Pokémon Sleep.',
                ],
            ],
            [
                'key' => 'pokemon-center',
                'name' => [
                    'nl' => 'Pokémon Center',
                    'en' => 'Pokémon Center',
                ],
                'description' => [
                    'nl' => 'Nieuws over producten, merchandise en aanbiedingen van Pokémon Center.',
                    'en' => 'News about Pokémon Center products, merchandise, and offers.',
                ],
            ],

            // Content types (SEO structuur)
            [
                'key' => 'reviews',
                'name' => [
                    'nl' => 'Reviews',
                    'en' => 'Reviews',
                ],
                'description' => [
                    'nl' => 'Reviews en beoordelingen van Pokémon-games, producten, kaarten en gerelateerde content.',
                    'en' => 'Reviews and evaluations of Pokémon games, products, cards, and related content.',
                ],
            ],
            [
                'key' => 'rumours-and-leaks',
                'name' => [
                    'nl' => 'Geruchten en lekken',
                    'en' => 'Rumours and Leaks',
                ],
                'description' => [
                    'nl' => 'Gemelde lekken en gelekte informatie over Pokémon en Nintendo.',
                    'en' => 'Reported leaks and leaked information related to Pokémon and Nintendo.',
                ],
            ],
            [
                'key' => 'deep-dive',
                'name' => [
                    'nl' => 'Diepgaande analyse',
                    'en' => 'Deep Dive',
                ],
                'description' => [
                    'nl' => 'Diepgaande analyses en uitgebreide verkenningen van Pokémon en gerelateerde onderwerpen.',
                    'en' => 'In-depth analysis and detailed explorations of Pokémon and related topics.',
                ],
            ],
            [
                'key' => 'card-gallery',
                'name' => [
                    'nl' => 'Kaartengalerij',
                    'en' => 'Card Gallery',
                ],
                'description' => [
                    'nl' => 'Kaartengalerijen met Pokémon Trading Card Game-kaarten en collecties.',
                    'en' => 'Card galleries featuring Pokémon Trading Card Game cards and collections.',
                ],
            ],
        ];

        foreach ($categories as $category) {
            $slugs = [
                'nl' => Str::slug($category['name']['nl']),
                'en' => Str::slug($category['name']['en']),
            ];

            Category::updateOrCreate(
                [
                    'key' => $category['key'],
                ],
                [
                    'name' => $category['name'],
                    'slug' => $slugs,
                    'description' => $category['description'],
                ],
            );
        }
    }
}