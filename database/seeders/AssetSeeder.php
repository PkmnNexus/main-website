<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\MediaFolder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use RuntimeException;

class AssetSeeder extends Seeder
{
    public function run(): void
    {
        $basePath = public_path('database');

        if (! File::isDirectory($basePath)) {
            throw new RuntimeException(
                "The image directory does not exist: {$basePath}"
            );
        }

        $assets = [
            [
                'file' => '1.jpg',
                'title' => 'Pokémon GO Featured Artwork',
                'alt' => 'Pokémon GO promotional artwork',
                'description' => 'Promotional artwork for Pokémon GO.',
                'folder' => 'Pokémon GO',
                'subfolder' => 'General',
            ],
            [
                'file' => '2.jpg',
                'title' => 'Pokémon GO Community Day',
                'alt' => 'Pokémon GO Community Day artwork',
                'description' => 'Artwork for a Pokémon GO Community Day.',
                'folder' => 'Pokémon GO',
                'subfolder' => 'Community Day',
            ],
            [
                'file' => '3.jpg',
                'title' => 'Pokémon GO Raid Guide',
                'alt' => 'Pokémon GO raid guide artwork',
                'description' => 'Artwork for a Pokémon GO raid guide.',
                'folder' => 'Pokémon GO',
                'subfolder' => 'Raid Guides',
            ],
            [
                'file' => '4.jpg',
                'title' => 'Pokémon GO Raid Boss',
                'alt' => 'Pokémon GO raid boss artwork',
                'description' => 'Artwork featuring a Pokémon GO raid boss.',
                'folder' => 'Pokémon GO',
                'subfolder' => 'Raid Bosses',
            ],
            [
                'file' => '5.jpg',
                'title' => 'Pokémon GO Event',
                'alt' => 'Pokémon GO event artwork',
                'description' => 'Promotional artwork for a Pokémon GO event.',
                'folder' => 'Pokémon GO',
                'subfolder' => 'Pokémon GO Events',
            ],
            [
                'file' => '6.jpg',
                'title' => 'Pokémon GO Battle League',
                'alt' => 'Pokémon GO Battle League artwork',
                'description' => 'Artwork related to the GO Battle League.',
                'folder' => 'Pokémon GO',
                'subfolder' => 'GO Battle League',
            ],
            [
                'file' => '7.jpg',
                'title' => 'Pokémon GO Shiny Pokémon',
                'alt' => 'Shiny Pokémon GO artwork',
                'description' => 'Artwork featuring shiny Pokémon.',
                'folder' => 'Pokémon GO',
                'subfolder' => 'Shiny Pokémon',
            ],
            [
                'file' => '8.jpg',
                'title' => 'Pokémon GO Spotlight Hour',
                'alt' => 'Pokémon GO Spotlight Hour artwork',
                'description' => 'Artwork for a Pokémon GO Spotlight Hour.',
                'folder' => 'Pokémon GO',
                'subfolder' => 'Spotlight Hour',
            ],
            [
                'file' => '9.jpg',
                'title' => 'Pokémon GO Research',
                'alt' => 'Pokémon GO research task artwork',
                'description' => 'Artwork related to Pokémon GO research tasks.',
                'folder' => 'Pokémon GO',
                'subfolder' => 'Research Tasks',
            ],
            [
                'file' => '10.jpg',
                'title' => 'Pokémon GO Update',
                'alt' => 'Pokémon GO update artwork',
                'description' => 'Artwork for a Pokémon GO update.',
                'folder' => 'Pokémon GO',
                'subfolder' => 'Pokémon GO Updates',
            ],
            [
                'file' => '11.jpg',
                'title' => 'Pokémon TCG Featured Artwork',
                'alt' => 'Pokémon Trading Card Game artwork',
                'description' => 'Promotional artwork for the Pokémon TCG.',
                'folder' => 'Pokémon TCG',
                'subfolder' => 'General',
            ],
            [
                'file' => '12.jpg',
                'title' => 'Pokémon TCG Scarlet and Violet',
                'alt' => 'Pokémon TCG Scarlet and Violet artwork',
                'description' => 'Artwork related to Scarlet & Violet.',
                'folder' => 'Pokémon TCG',
                'subfolder' => 'Scarlet & Violet',
            ],
            [
                'file' => '13.jpg',
                'title' => 'Pokémon TCG Mega Evolutions',
                'alt' => 'Pokémon TCG Mega Evolution artwork',
                'description' => 'Artwork featuring Mega Evolution.',
                'folder' => 'Pokémon TCG',
                'subfolder' => 'Mega Evolutions',
            ],
            [
                'file' => '14.jpg',
                'title' => 'Pokémon TCG Pocket',
                'alt' => 'Pokémon TCG Pocket artwork',
                'description' => 'Artwork related to Pokémon TCG Pocket.',
                'folder' => 'Pokémon TCG',
                'subfolder' => 'Pokémon TCG Pocket',
            ],
            [
                'file' => '15.jpg',
                'title' => 'Pokémon TCG Card Artwork',
                'alt' => 'Pokémon trading card artwork',
                'description' => 'Artwork for Pokémon trading cards.',
                'folder' => 'Pokémon TCG',
                'subfolder' => 'Card Artwork',
            ],
            [
                'file' => '16.jpg',
                'title' => 'Pokémon TCG Expansion',
                'alt' => 'Pokémon TCG expansion artwork',
                'description' => 'Artwork for a Pokémon TCG expansion.',
                'folder' => 'Pokémon TCG',
                'subfolder' => 'Expansion Sets',
            ],
            [
                'file' => '17.jpg',
                'title' => 'Pokémon TCG Booster Pack',
                'alt' => 'Pokémon TCG booster pack artwork',
                'description' => 'Artwork related to Pokémon TCG booster packs.',
                'folder' => 'Pokémon TCG',
                'subfolder' => 'Booster Packs',
            ],
            [
                'file' => '18.jpg',
                'title' => 'Pokémon TCG Deck Guide',
                'alt' => 'Pokémon TCG deck guide artwork',
                'description' => 'Artwork for a Pokémon TCG deck guide.',
                'folder' => 'Pokémon TCG',
                'subfolder' => 'Deck Guides',
            ],
            [
                'file' => '19.jpg',
                'title' => 'Pokémon Legends Z-A',
                'alt' => 'Pokémon Legends Z-A game artwork',
                'description' => 'Promotional artwork for Pokémon Legends: Z-A.',
                'folder' => 'Pokémon Games',
                'subfolder' => 'Pokémon Legends: Z-A',
            ],
            [
                'file' => '20.jpg',
                'title' => 'Pokémon Scarlet and Violet',
                'alt' => 'Pokémon Scarlet and Violet game artwork',
                'description' => 'Artwork for Pokémon Scarlet & Violet.',
                'folder' => 'Pokémon Games',
                'subfolder' => 'Pokémon Scarlet & Violet',
            ],
            [
                'file' => '21.jpg',
                'title' => 'Pokémon Legends Arceus',
                'alt' => 'Pokémon Legends Arceus game artwork',
                'description' => 'Artwork for Pokémon Legends: Arceus.',
                'folder' => 'Pokémon Games',
                'subfolder' => 'Pokémon Legends: Arceus',
            ],
            [
                'file' => '22.jpg',
                'title' => 'Pokémon Game Guide',
                'alt' => 'Pokémon game guide artwork',
                'description' => 'Artwork for a Pokémon game guide.',
                'folder' => 'Pokémon Games',
                'subfolder' => 'Game Guides',
            ],
            [
                'file' => '23.jpg',
                'title' => 'Pokémon Horizons',
                'alt' => 'Pokémon Horizons anime artwork',
                'description' => 'Artwork related to Pokémon Horizons.',
                'folder' => 'Pokémon Anime & Manga',
                'subfolder' => 'Pokémon Horizons',
            ],
            [
                'file' => '24.jpg',
                'title' => 'Pokémon Anime',
                'alt' => 'Pokémon anime artwork',
                'description' => 'Artwork related to the Pokémon anime.',
                'folder' => 'Pokémon Anime & Manga',
                'subfolder' => 'Pokémon Anime',
            ],
            [
                'file' => '25.jpg',
                'title' => 'Pokémon Movie',
                'alt' => 'Pokémon movie artwork',
                'description' => 'Artwork related to a Pokémon movie.',
                'folder' => 'Pokémon Anime & Manga',
                'subfolder' => 'Pokémon Movies',
            ],
            [
                'file' => '26.jpg',
                'title' => 'Pokémon Mega Evolution',
                'alt' => 'Pokémon Mega Evolution artwork',
                'description' => 'Artwork featuring Pokémon Mega Evolution.',
                'folder' => 'Pokémon',
                'subfolder' => 'Mega Evolutions',
            ],
            [
                'file' => '27.jpg',
                'title' => 'Pokémon Legendary',
                'alt' => 'Legendary Pokémon artwork',
                'description' => 'Artwork featuring Legendary Pokémon.',
                'folder' => 'Pokémon',
                'subfolder' => 'Legendary Pokémon',
            ],
            [
                'file' => '28.jpg',
                'title' => 'Pokémon Starter',
                'alt' => 'Pokémon starter artwork',
                'description' => 'Artwork featuring starter Pokémon.',
                'folder' => 'Pokémon',
                'subfolder' => 'Starter Pokémon',
            ],
            [
                'file' => '29.jpg',
                'title' => 'Pokémon Breaking News',
                'alt' => 'Pokémon breaking news artwork',
                'description' => 'Artwork for a Pokémon breaking news article.',
                'folder' => 'News & Editorial',
                'subfolder' => 'Breaking News',
            ],
            [
                'file' => '30.jpg',
                'title' => 'Pokémon Article Hero',
                'alt' => 'Pokémon article hero image',
                'description' => 'Hero image for a Pokémon article.',
                'folder' => 'News & Editorial',
                'subfolder' => 'Article Hero Images',
            ],
            [
                'file' => '31.jpg',
                'title' => 'Pokémon Social Media Graphic',
                'alt' => 'Pokémon social media graphic',
                'description' => 'Graphic for Pokémon social media content.',
                'folder' => 'Website & Social Media',
                'subfolder' => 'Social Media',
            ],
        ];

        DB::transaction(function () use ($assets, $basePath): void {
            foreach ($assets as $data) {
                $filePath = $basePath . '/' . $data['file'];

                if (! File::exists($filePath)) {
                    $this->command?->warn(
                        "Skipping missing image: {$data['file']}"
                    );

                    continue;
                }

                $folder = $this->findFolder(
                    $data['folder'],
                    $data['subfolder']
                );

                $asset = Asset::updateOrCreate(
                    [
                        'title' => $data['title'],
                    ],
                    [
                        'media_folder_id' => $folder->id,
                        'alt' => $data['alt'],
                        'description' => $data['description'],
                    ]
                );

                $existingMedia = $asset->getFirstMedia('asset');

                if (
                    $existingMedia
                    && $existingMedia->file_name === $data['file']
                ) {
                    $this->command?->info(
                        "Already imported: {$data['file']}"
                    );

                    continue;
                }

                $media = $asset
                    ->addMedia($filePath)
                    ->preservingOriginal()
                    ->usingFileName($data['file'])
                    ->toMediaCollection('asset');

                $media->forceFill([
                    'uuid' => (string) Str::uuid(),
                ])->save();

                $asset->refresh()->syncMediaMetadata();

                $this->command?->info(
                    "Imported: {$data['file']}"
                );
            }
        });
    }

    protected function findFolder(
        string $parentName,
        string $childName
    ): MediaFolder {
        $parent = MediaFolder::query()
            ->whereNull('parent_id')
            ->where('slug', Str::slug($parentName))
            ->first();

        if (! $parent) {
            throw new RuntimeException(
                "Media folder not found: {$parentName}. "
                . 'Run MediaFolderSeeder first.'
            );
        }

        $child = MediaFolder::query()
            ->where('parent_id', $parent->id)
            ->where(
                'slug',
                Str::slug($parent->slug . '-' . $childName)
            )
            ->first();

        if (! $child) {
            throw new RuntimeException(
                "Subfolder not found: {$parentName} → {$childName}. "
                . 'Run MediaFolderSeeder first.'
            );
        }

        return $child;
    }
}