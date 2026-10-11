<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\ArticleDailyView>
 */
class ArticleDailyViewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'article_id' => Article::factory(),
            'view_date' => fake()->dateTimeBetween('-90 days', 'today'),
            'views' => fake()->numberBetween(1, 500),
        ];
    }
}