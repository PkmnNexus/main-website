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
                'name' => 'Pokémon News',
                'description' => 'General Pokémon news and announcements.',
            ],
            [
                'name' => 'Pokémon Games',
                'description' => 'News, features, and updates about Pokémon games.',
            ],
            [
                'name' => 'Pokémon Rumors',
                'description' => 'Rumors, speculation, and unconfirmed Pokémon information.',
            ],
            [
                'name' => 'Pokémon Guides',
                'description' => 'Guides, tips, and helpful information for Pokémon games and content.',
            ],
            [
                'name' => 'Pokémon Events',
                'description' => 'Coverage of Pokémon events, tournaments, and special occasions.',
            ],
            [
                'name' => 'Pokémon Updates',
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

            // Nintendo ecosystem
            [
                'name' => 'Nintendo Switch',
                'description' => 'News and updates about Pokémon and Nintendo games on Nintendo Switch.',
            ],
            [
                'name' => 'Nintendo Switch 2',
                'description' => 'News, updates, and information about Pokémon and Nintendo games on Nintendo Switch 2.',
            ],
            [
                'name' => 'Nintendo News',
                'description' => 'News and announcements from Nintendo relevant to Pokémon and its ecosystem.',
            ],
            [
                'name' => 'Nintendo Games',
                'description' => 'News and information about Nintendo games and releases.',
            ],

            // Content types (SEO structuur)
            [
                'name' => 'Reviews',
                'description' => 'Reviews and evaluations of Pokémon games, products, cards, and related content.',
            ],
            [
                'name' => 'Leaks',
                'description' => 'Reported leaks and leaked information related to Pokémon and Nintendo.',
            ],
            [
                'name' => 'Tier Lists',
                'description' => 'Rankings and tier lists for Pokémon, cards, characters, and gameplay elements.',
            ],
            [
                'name' => 'How To Guides',
                'description' => 'Step-by-step guides and instructions for Pokémon games and related content.',
            ],
            [
                'name' => 'Opinion',
                'description' => 'Opinion and commentary on Pokémon, Nintendo, and related topics.',
            ],
            [
                'name' => 'News',
                'description' => 'The latest news and developments from the Pokémon and Nintendo community.',
            ],
            [
                'name' => 'Deep Dive',
                'description' => 'In-depth analysis and detailed explorations of Pokémon and related topics.',
            ],
            [
                'name' => 'Card Gallery',
                'description' => 'Card galleries featuring Pokémon Trading Card Game cards and collections.',
            ],

            // Community / meta
            [
                'name' => 'Esports',
                'description' => 'News and coverage of Pokémon esports, competitions, and professional events.',
            ],
            [
                'name' => 'Competitive Play',
                'description' => 'Competitive Pokémon strategies, tournaments, formats, and gameplay.',
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
