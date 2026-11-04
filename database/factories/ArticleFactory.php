<?php

namespace Database\Factories;

use App\Enums\ArticleStatus;
use App\Models\Article;
use App\Models\Asset;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        return [
            'category_id' => Category::query()
                ->inRandomOrder()
                ->value('id'),

            'hero_asset_id' => Asset::query()
                ->inRandomOrder()
                ->value('id'),

            // Video
            'video_url' => $this->faker->boolean(30)
                ? 'https://www.youtube.com/watch?v=qva62VDTcqc'
                : null,

            'youtube_published_at' => null,
            'youtube_thumbnail_url' => null,
            'youtube_duration' => null,

            // Article flags
            'is_breaking' => $this->faker->boolean(5),
            'is_featured' => $this->faker->boolean(15),
            'is_pokemon_go_featured' => $this->faker->boolean(15),

            // SEO
            'robots_index' => true,
            'robots_follow' => true,

            // Open Graph
            'og_type' => 'article',

            // Publishing
            'user_id' => User::query()
                ->inRandomOrder()
                ->value('id'),

            'status' => ArticleStatus::Published,

            'published_at' => now()
                ->subDays($this->faker->numberBetween(0, 180))
                ->subHours($this->faker->numberBetween(0, 23))
                ->subMinutes($this->faker->numberBetween(0, 59)),

            'expires_at' => null,

            'reading_time' => $this->faker->numberBetween(2, 12),
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'status' => ArticleStatus::Published,
            'published_at' => now(),
        ]);
    }

    public function featured(): static
    {
        return $this->state(fn () => [
            'is_featured' => true,
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn () => [
            'status' => ArticleStatus::Draft,
            'published_at' => null,
        ]);
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Article $article): void {
            $tags = Tag::query()
                ->inRandomOrder()
                ->limit($this->faker->numberBetween(2, 4))
                ->get();

            $article->syncTags($tags);
        });
    }
}