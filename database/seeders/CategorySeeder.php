<?php

namespace Database\Seeders;

use App\Models\Category;
use Database\Seeders\Concerns\LoadsSeederData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    use LoadsSeederData;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = $this->loadSeederData(
            'categories',
            ['name', 'description'],
        );

        foreach ($categories as $category) {
            $slugs = [];

            foreach ($category['name'] as $language => $name) {
                $slugs[$language] = Str::slug($name);
            }

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