<?php

namespace Database\Seeders;

use App\Models\Page;
use Database\Seeders\Concerns\LoadsSeederData;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    use LoadsSeederData;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = $this->loadSeederData(
            'pages',
            [
                'slug',
                'title',
                'content',
                'meta_description',
                'meta_keywords',
                'og_title',
                'og_description',
            ],
        );

        foreach ($pages as $page) {
            $data = $page;

            unset($data['key']);

            Page::updateOrCreate(
                ['key' => $page['key']],
                $data,
            );
        }
    }
}