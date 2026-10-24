<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Example comments for generating realistic seed data.
     *
     * @var array<int, string>
     */
    private const BODIES = [
        'This is really interesting! I had not noticed that before.',
        'Thanks for the explanation. This makes things much clearer.',
        'I wonder how this will affect the next update.',
        'I have been waiting for more information about this!',
        'Great article. Looking forward to seeing what happens next.',
        'That is a pretty interesting change. I am curious to see how it works in practice.',
        'I agree with this, although there are a few things I would like to see improved.',
        'Does anyone know if this is already available?',
        'I hope we get more details about this soon.',
        'This could make a big difference for players.',
        'Interesting news! I will definitely keep an eye on this.',
        'I had a similar experience recently. Good to see this being discussed.',
        'Hopefully we get an official announcement soon.',
        'I am not entirely convinced yet, but the idea has potential.',
        'Thanks for sharing this with the community!',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'article_id' => null,
            'user_id' => null,
            'parent_id' => null,
            'body' => fake()->randomElement(self::BODIES),
        ];
    }
}