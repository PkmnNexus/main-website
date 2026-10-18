<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Source;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $sources = Source::query()->pluck('id');

        Article::factory()
            ->count(250)
            ->create()
            ->each(function (Article $article) use ($sources): void {
                $article->sources()->sync(
                    $sources->shuffle()->take(fake()->numberBetween(1, 3))
                );
            });
    }
}