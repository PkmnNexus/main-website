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

            'content' => '
                <p>
                    Pokémon GO continues to bring new discoveries to Trainers around the world, with
                    new Pokémon, seasonal events, raids, and special research regularly changing the
                    way players explore the game. Whether you are a new Trainer or a longtime player,
                    there is always something new to discover.
                </p>

                <h2>What to expect from the latest Pokémon GO event</h2>

                <p>
                    The latest event introduces a selection of bonuses and encounters designed to
                    encourage Trainers to get outside and explore. During the event, certain Pokémon
                    will appear more frequently in the wild, while others may become available through
                    raids or research.
                </p>

                <p>
                    Trainers should also keep an eye out for <strong>Shiny Pokémon</strong>. While
                    Shiny encounters are never guaranteed, event bonuses can provide more opportunities
                    to encounter a Pokémon and potentially add a rare variant to your collection.
                </p>

                <h3>Event bonuses</h3>

                <ul>
                    <li>Increased Pokémon encounters in the wild</li>
                    <li>Additional rewards from selected research tasks</li>
                    <li>Bonus experience and Stardust</li>
                    <li>Special raid encounters</li>
                    <li>Increased chances of encountering selected Shiny Pokémon</li>
                </ul>

                <h2>Which Pokémon should you look out for?</h2>

                <p>
                    Some Pokémon are particularly interesting during the event because of their
                    availability, evolution requirements, or usefulness in battles. Trainers who are
                    looking to expand their collection should make sure they have enough Poké Balls
                    and storage space before heading out.
                </p>

                <h3>Pokémon worth catching</h3>

                <p>
                    A good event strategy is to focus on Pokémon that are difficult to find outside
                    of special events. Pokémon with useful evolutions can also be worth prioritizing,
                    especially when an event provides additional Candy or other evolution bonuses.
                </p>

                <ol>
                    <li>
                        <strong>Check your Pokémon storage.</strong>
                        Make sure you have enough room before starting your adventure.
                    </li>
                    <li>
                        <strong>Stock up on Poké Balls.</strong>
                        PokéStops and Gifts can help replenish your supplies.
                    </li>
                    <li>
                        <strong>Take advantage of event bonuses.</strong>
                        Plan your play sessions around the bonuses that matter most to you.
                    </li>
                </ol>

                <blockquote>
                    <p>
                        The best Pokémon GO events are the ones that give Trainers a reason to explore,
                        catch Pokémon, and play together.
                    </p>
                </blockquote>

                <h2>Raids and battles</h2>

                <p>
                    Raids are another important part of many Pokémon GO events. Before joining a raid,
                    Trainers should check the Pokémon\'s typing and prepare a team with appropriate
                    counters.
                </p>

                <h3>Preparing your raid team</h3>

                <p>
                    Building an effective raid team starts with understanding the weaknesses of the
                    raid boss. For example, a Water-type Pokémon may be vulnerable to Electric- and
                    Grass-type attacks, while a Dragon-type Pokémon can have different weaknesses
                    depending on its secondary typing.
                </p>

                <table>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Common weakness</th>
                            <th>Useful counters</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Water</td>
                            <td>Electric, Grass</td>
                            <td>Pikachu, Raikou, Venusaur</td>
                        </tr>
                        <tr>
                            <td>Fire</td>
                            <td>Water, Ground, Rock</td>
                            <td>Kyogre, Garchomp, Tyranitar</td>
                        </tr>
                        <tr>
                            <td>Dragon</td>
                            <td>Ice, Fairy, Dragon</td>
                            <td>Mamoswine, Gardevoir, Dragonite</td>
                        </tr>
                    </tbody>
                </table>

                <h2>Research and rewards</h2>

                <p>
                    Special Research and Field Research can provide additional encounters and rewards
                    throughout an event. Always check the requirements of a research task before
                    completing it, as some objectives may be easier to finish in specific locations
                    or during particular parts of the event.
                </p>

                <h3>Useful items to keep ready</h3>

                <ul>
                    <li>Poké Balls and Great Balls</li>
                    <li>Pinap Berries</li>
                    <li>Revives and Potions</li>
                    <li>Lucky Eggs</li>
                    <li>Star Pieces</li>
                    <li>Incense</li>
                </ul>

                <p>
                    <em>Tip:</em> If you are planning a longer play session, prepare your items before
                    the event begins so you can spend more time catching Pokémon instead of managing
                    your inventory.
                </p>

                <h2>Playing with other Trainers</h2>

                <p>
                    Pokémon GO is often more enjoyable when played together. Raids, Party Play, and
                    trading can give Trainers additional reasons to meet up and explore their local
                    area.
                </p>

                <p>
                    If you are organising a raid group, consider sharing the meeting location and
                    start time in advance. A simple message such as
                    <a href="#">"Join our local raid group"</a>
                    can make it easier for other Trainers to participate.
                </p>

                <h3>Stay safe while playing</h3>

                <p>
                    Always pay attention to your surroundings while playing Pokémon GO. Keep your
                    phone away when crossing roads, respect private property, and follow local rules
                    when visiting parks, landmarks, and other public places.
                </p>

                <hr>

                <h2>Final thoughts</h2>

                <p>
                    Whether you are hunting for a new Shiny, preparing for a difficult raid, or simply
                    exploring your neighbourhood, Pokémon GO events can offer plenty of opportunities
                    to catch something new. Preparing your items and knowing what to expect can help
                    you make the most of your time.
                </p>

                <p>
                    <strong>Good luck, Trainers, and happy hunting!</strong>
                </p>
            ',

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