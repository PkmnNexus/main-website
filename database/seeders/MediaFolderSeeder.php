<?php

namespace Database\Seeders;

use App\Models\MediaFolder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MediaFolderSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            $folders = [
                [
                    'name' => 'Pokémon GO',
                    'icon' => 'heroicon-o-globe-alt',
                    'color' => 'success',
                    'sort_order' => 1,
                    'children' => [
                        'General',
                        'Community Day',
                        'Raid Guides',
                        'Raid Bosses',
                        'Pokémon GO Events',
                        'GO Battle League',
                        'Shiny Pokémon',
                        'Spotlight Hour',
                        'Research Tasks',
                        'Pokémon GO Updates',
                        'Team GO Rocket',
                        'Pokémon GO Maps',
                    ],
                ],
                [
                    'name' => 'Pokémon TCG',
                    'icon' => 'heroicon-o-squares-2x2',
                    'color' => 'warning',
                    'sort_order' => 2,
                    'children' => [
                        'General',
                        'Scarlet & Violet',
                        'Mega Evolutions',
                        'Pokémon TCG Pocket',
                        'Card Artwork',
                        'Card Collections',
                        'Expansion Sets',
                        'Booster Packs',
                        'Deck Guides',
                        'Competitive Play',
                        'TCG News',
                        'Product Photography',
                    ],
                ],
                [
                    'name' => 'Pokémon Games',
                    'icon' => 'heroicon-o-puzzle-piece',
                    'color' => 'info',
                    'sort_order' => 3,
                    'children' => [
                        'Pokémon Legends: Z-A',
                        'Pokémon Scarlet & Violet',
                        'Pokémon Sword & Shield',
                        'Pokémon Brilliant Diamond & Shining Pearl',
                        'Pokémon Legends: Arceus',
                        'Pokémon Scarlet & Violet DLC',
                        'Pokémon HOME',
                        'Pokémon Mystery Dungeon',
                        'Pokémon Spin-offs',
                        'Gameplay Screenshots',
                        'Game Guides',
                    ],
                ],
                [
                    'name' => 'Pokémon Anime & Manga',
                    'icon' => 'heroicon-o-film',
                    'color' => 'danger',
                    'sort_order' => 4,
                    'children' => [
                        'Pokémon Horizons',
                        'Pokémon Anime',
                        'Ash Ketchum',
                        'Anime Characters',
                        'Anime Episodes',
                        'Pokémon Movies',
                        'Pokémon Manga',
                        'Promotional Artwork',
                    ],
                ],

            ];

            foreach ($folders as $folderData) {
                $children = $folderData['children'];

                unset($folderData['children']);

                $parent = MediaFolder::updateOrCreate(
                    [
                        'parent_id' => null,
                        'slug' => Str::slug($folderData['name']),
                    ],
                    [
                        ...$folderData,
                        'is_system' => true,
                    ]
                );

                foreach ($children as $index => $childName) {
                    $childSlug = Str::slug(
                        $parent->slug . '-' . $childName
                    );

                    MediaFolder::updateOrCreate(
                        [
                            'slug' => $childSlug,
                        ],
                        [
                            'parent_id' => $parent->id,
                            'name' => $childName,
                            'icon' => null,
                            'color' => null,
                            'sort_order' => $index + 1,
                            'is_system' => true,
                        ]
                    );
                }
            }
        });
    }
}