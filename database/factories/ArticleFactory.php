<?php

namespace Database\Factories;

use App\Enums\ArticleStatus;
use App\Models\Article;
use App\Models\Asset;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        $title = fake()->sentence(6);

        $status = fake()->randomElement(ArticleStatus::cases());

        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(1000, 999999),

            'excerpt' => fake()->paragraph(),

            'content' => collect(fake()->paragraphs(5))
                ->map(fn (string $paragraph) => "<p>{$paragraph}</p>")
                ->implode("\n"),

            'category_id' => Category::query()
                ->inRandomOrder()
                ->value('id'),

            'hero_asset_id' => Asset::query()
                ->inRandomOrder()
                ->value('id'),

            'video_url' => fake()->optional(0.2)->url(),

            'is_breaking' => fake()->boolean(5),
            'is_featured' => fake()->boolean(15),
            'is_pokemon_go_featured' => fake()->boolean(20),

            'meta_title' => $title,
            'meta_description' => fake()->sentence(),
            'meta_keywords' => fake()->randomElements([
                'Pokémon',
                'Pokémon GO',
                'Pokémon TCG',
                'Pokémon nieuws',
                'Pokémon games',
                '攻略',
                '攻略 gids',
            ], 3),

            'canonical' => null,

            'robots_index' => true,
            'robots_follow' => true,

            'og_title' => $title,
            'og_description' => fake()->sentence(),
            'og_type' => 'article',

            'user_id' => User::query()
                ->inRandomOrder()
                ->value('id'),

            'status' => $status,

            'published_at' => $status === ArticleStatus::Published
                ? fake()->dateTimeBetween('-1 year', 'now')
                : null,

            'expires_at' => null,
        ];
    }
}