<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'slug' => 'home',
                'data' => [
                    'page' => 'Home',
                    'title' => 'PkmnInsider - Pokémon News & Guides',
                    'meta_description' => 'Discover the latest Pokémon news, competitive guides, and in-depth articles on PkmnInsider.',
                    'meta_keywords' => 'pokemon, news, guides, tcg, pokedex',
                    'og_title' => 'Og Title Test',
                    'og_description' => 'Og Description Test',
                    'is_active' => true,
                ],
            ],
            [
                'slug' => 'articles',
                'data' => [
                    'page' => 'Articles',
                    'title' => 'Pokémon Articles - PkmnInsider',
                    'meta_description' => 'Read in-depth Pokémon articles, guides, strategies and analyses on PkmnInsider.',
                    'meta_keywords' => 'pokemon articles, pokemon guides, tcg articles, pokemon analysis',
                    'og_title' => 'Pokémon Articles - PkmnInsider',
                    'og_description' => 'Explore detailed Pokémon articles and guides.',
                    'is_active' => true,
                ],
            ],
            [
                'slug' => 'tag',
                'data' => [
                    'page' => 'Tag',
                    'title' => 'Pokémon Articles - PkmnInsider',
                    'meta_description' => 'Read in-depth Pokémon articles, guides, strategies and analyses on PkmnInsider.',
                    'meta_keywords' => 'pokemon articles, pokemon guides, tcg articles, pokemon analysis',
                    'og_title' => 'Pokémon Articles - PkmnInsider',
                    'og_description' => 'Explore detailed Pokémon articles and guides.',
                    'is_active' => true,
                ],
            ],
            [
                'slug' => 'category',
                'data' => [
                    'page' => 'Category',
                    'title' => 'Pokémon Articles - PkmnInsider',
                    'meta_description' => 'Read in-depth Pokémon articles, guides, strategies and analyses on PkmnInsider.',
                    'meta_keywords' => 'pokemon articles, pokemon guides, tcg articles, pokemon analysis',
                    'og_title' => 'Pokémon Articles - PkmnInsider',
                    'og_description' => 'Explore detailed Pokémon articles and guides.',
                    'is_active' => true,
                ],
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(
                ['slug' => $page['slug']],
                $page['data']
            );
        }
    }
}
