<?php

namespace Database\Factories;

use App\Enums\ArticleStatus;
use App\Models\Article;
use App\Models\Asset;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use Spatie\Tags\Tag;
/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        $titles = [
            'Community Day Guide: Best Pokémon to Catch This Month',
            'How to Prepare for Upcoming Raid Events in Pokémon GO',
            'Top Meta Decks Dominating the Pokémon TCG Scene',
            'Beginner Guide: Building Your First Competitive TCG Deck',
            'Shiny Hunting Strategy Explained for Efficient Farming',
            'Raid Counters Breakdown: Beat the Hardest Bosses Easily',
            'Pokémon GO Meta Shift: What Changed This Season?',
            'Advanced TCG Energy Management Techniques Explained',
            'How to Maximize Stardust Gains During Events',
            'Best Pokémon for PvP Battles Right Now',
            'Elite Raid Strategy Guide for High-Level Players',
            'How IVs Affect Pokémon Performance in Real Battles',
            'Rare Candy Farming Tips for Faster Progression',
            'Ultra League Meta Analysis and Top Picks',
            'Best Budget Decks for Competitive TCG Play',
            'How to Counter Dragon-Type Pokémon Efficiently',
            'Field Research Rewards Guide for Pokémon GO',
            'Shiny Odds Explained: What You Need to Know',
            'Event Calendar Breakdown for Pokémon GO Players',
            'How to Build Winning Strategies in Pokémon TCG',
        ];

        $excerptPool = [
            'Discover detailed strategies and insights to improve your Pokémon gameplay across all modes and events.',
            'A complete breakdown of tactics, counters, and optimization tips for competitive play.',
            'Learn how to maximize efficiency, resources, and performance in both casual and ranked environments.',
            'Everything you need to stay ahead of the meta and improve your overall gameplay experience.',
        ];

        $contentPool = [
            'This article explores core gameplay mechanics, strategic decision-making, and advanced optimization techniques used by experienced players.',
            'Understanding the meta is key to improving performance. This guide breaks down key systems, matchups, and strategies.',
            'By analyzing current trends and competitive data, players can significantly improve win rates and resource efficiency.',
            'Success in Pokémon gameplay depends on preparation, adaptability, and knowledge of game systems and mechanics.',
        ];

        $title = $this->faker->randomElement($titles);

        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1000, 99999),

            'excerpt' => $this->faker->randomElement($excerptPool),

            'content' => collect($this->faker->randomElements($contentPool, 2))
                ->map(fn (string $paragraph) => "<p>{$paragraph}</p>")
                ->implode("\n"),

            'category_id' => Category::query()
                ->inRandomOrder()
                ->value('id'),

            'hero_asset_id' => Asset::query()
                ->inRandomOrder()
                ->value('id'),

            'video_url' => $this->faker->boolean(30)
                ? 'https://www.youtube.com/watch?v=qva62VDTcqc'
                : null,

            'is_breaking' => $this->faker->boolean(5),
            'is_featured' => $this->faker->boolean(15),
            'is_pokemon_go_featured' => $this->faker->boolean(15),

            // SEO
            'meta_title' => $this->faker->optional()->sentence(6),
            'meta_description' => $this->faker->optional()->sentence(15),
            'meta_keywords' => $this->faker->optional()->words(5, true),
            'canonical' => null,

            'robots_index' => true,
            'robots_follow' => true,

            // Open Graph
            'og_title' => null,
            'og_description' => null,
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
            'views' => $this->faker->numberBetween(0, 5000),
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
        return $this->afterCreating(function (Article $article) {
            $tags = collect([
                'Pokémon GO',
                'TCG',
                'Raid',
                'PvP',
                'Shiny',
                'Community Day',
                'Guide',
                'Meta',
            ])
                ->random($this->faker->numberBetween(2, 4))
                ->map(function (string $name) {
                    return \Spatie\Tags\Tag::firstOrCreate(
                        [
                            'name' => ['en' => $name],
                        ],
                        [
                            'slug' => Str::slug($name),
                        ],
                    );
                });

            $article->syncTags($tags);
        });
    }
}