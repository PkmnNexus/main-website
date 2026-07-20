<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Page;

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
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(
                ['slug' => $page['slug']],
                $page['data']
            );
        }
    }
}
