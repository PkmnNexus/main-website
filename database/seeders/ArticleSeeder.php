<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Source;
use Database\Seeders\Concerns\LoadsSeederData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    use LoadsSeederData;

    public function run(): void
    {
        $sources = Source::query()->pluck('id');

        $articles = collect($this->loadSeederData(
            'articles',
            [
                'title',
                'excerpt',
                'summary',
                'content',
                'meta_title',
                'meta_description',
                'meta_keywords',
                'canonical',
                'og_title',
                'og_description',
            ],
        ));

        $locales = config('localization.enabled', false)
            ? array_keys(config('localization.locales', []))
            : [config('localization.default', 'en')];

        for ($i = 0; $i < 250; $i++) {
            $articleData = $articles->random();
            $slugSuffix = fake()->unique()->numberBetween(1000, 99999);

            $articleData['slug'] = [];

            foreach ($locales as $locale) {
                $articleData['slug'][$locale] = Str::slug(
                    $articleData['title'][$locale] ?? $articleData['title'][config('localization.default', 'en')],
                ) . '-' . $slugSuffix;
            }

            unset($articleData['key']);

            $article = Article::factory()
                ->state($articleData)
                ->create();

            $article->sources()->sync(
                $sources->shuffle()->take(fake()->numberBetween(1, 3))
            );
        }
    }
}