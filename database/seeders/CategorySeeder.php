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
            [
                'name' => 'Pokémon GO',
                'description' => 'General Pokémon news and announcements.',
            ],
            [
                'name' => 'Trading Card Game',
                'description' => 'Articles about the Pokémon Trading Card Game.',
            ],
            [
                'name' => 'Games',
                'description' => 'News and guides about Pokémon games.',
            ],
            [
                'name' => 'Anime',
                'description' => 'Articles about the Pokémon anime.',
            ],
            [
                'name' => 'Events',
                'description' => 'Coverage of Pokémon events and tournaments.',
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
