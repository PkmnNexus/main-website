<?php

namespace Database\Seeders;

use App\Models\Tag;
use Database\Seeders\Concerns\LoadsSeederData;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    use LoadsSeederData;

    public function run(): void
    {
        $tags = $this->loadSeederData('tags', ['name']);

        foreach ($tags as $tagData) {
            $tag = Tag::firstOrNew([
                'slug' => $tagData['key'],
            ]);

            foreach ($tagData['name'] as $locale => $name) {
                $tag->setTranslation('name', $locale, $name);
            }

            $tag->save();
        }
    }
}