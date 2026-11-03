<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Seed comments for published, non-video articles.
     */
    public function run(): void
    {
        $articles = Article::query()
            ->published()
            ->whereNull('video_url')
            ->get();

        $users = User::query()
            ->whereNotNull('email_verified_at')
            ->get();

        if ($articles->isEmpty() || $users->isEmpty()) {
            $this->command?->warn(
                'Comments were not seeded: no eligible articles or verified users were found.'
            );

            return;
        }

        // Number of top-level comments to generate.
        $rootCommentCount = 50;

        for ($i = 0; $i < $rootCommentCount; $i++) {
            $article = $articles->random();

            $locale = $this->getArticleLocale($article);

            $root = $this->createComment(
                article: $article,
                users: $users,
                locale: $locale,
            );

            // Generate replies on level 2.
            $replyCount = fake()->numberBetween(0, 3);

            for ($j = 0; $j < $replyCount; $j++) {
                $reply = $this->createComment(
                    article: $article,
                    users: $users,
                    locale: $locale,
                    parent: $root,
                );

                // Generate replies on level 3.
                $nestedReplyCount = fake()->numberBetween(0, 2);

                for ($k = 0; $k < $nestedReplyCount; $k++) {
                    $this->createComment(
                        article: $article,
                        users: $users,
                        locale: $locale,
                        parent: $reply,
                    );
                }
            }
        }

        $this->command?->info(
            'Comment seed data generated successfully.'
        );
    }

    /**
     * Determine the locale used for the article.
     */
    private function getArticleLocale(Article $article): string
    {
        $defaultLocale = config('localization.default', 'en');

        $availableLocales = array_keys(
            $article->getTranslations('title')
        );

        $availableLocales = array_values(array_intersect(
            $availableLocales,
            array_keys(config('localization.locales', [])),
        ));

        return $availableLocales
            ? fake()->randomElement($availableLocales)
            : $defaultLocale;
    }

    /**
     * Create a comment with a randomized timestamp.
     */
    private function createComment(
        Article $article,
        $users,
        string $locale,
        ?Comment $parent = null,
    ): Comment {
        $createdAt = fake()->dateTimeBetween('-30 days', 'now');

        return Comment::factory()
            ->state(Comment::factory()->forLocale($locale))
            ->create([
                'article_id' => $article->id,
                'user_id' => $users->random()->id,
                'parent_id' => $parent?->id,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
    }
}