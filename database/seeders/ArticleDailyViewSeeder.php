<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleDailyView;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ArticleDailyViewSeeder extends Seeder
{
    public function run(): void
    {
        $articles = Article::query()->get();

        foreach ($articles as $article) {
            $date = Carbon::today()->subDays(89);

            while ($date->lte(Carbon::today())) {
                ArticleDailyView::factory()->create([
                    'article_id' => $article->id,
                    'view_date' => $date->toDateString(),
                ]);

                $date->addDay();
            }
        }
    }
}