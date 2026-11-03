<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Example English comments for generating realistic seed data.
     *
     * @var array<int, string>
     */
    private const ENGLISH_BODIES = [
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
     * Example Dutch comments for generating realistic seed data.
     *
     * @var array<int, string>
     */
    private const DUTCH_BODIES = [
        'Dit is echt interessant! Dat was me nog niet eerder opgevallen.',
        'Bedankt voor de uitleg. Zo wordt het een stuk duidelijker.',
        'Ik vraag me af wat dit betekent voor de volgende update.',
        'Hier wacht ik al een tijdje op! Eindelijk meer informatie.',
        'Mooi artikel. Benieuwd wat er hierna gaat gebeuren.',
        'Dat is een interessante verandering. Ik ben benieuwd hoe dit in de praktijk werkt.',
        'Ik ben het hiermee eens, al zijn er nog een paar dingen die beter kunnen.',
        'Weet iemand of dit ondertussen al beschikbaar is?',
        'Hopelijk krijgen we hier binnenkort meer details over.',
        'Dit kan een groot verschil maken voor spelers.',
        'Interessant nieuws! Ik ga dit zeker in de gaten houden.',
        'Ik heb onlangs iets vergelijkbaars meegemaakt. Goed dat dit besproken wordt.',
        'Hopelijk volgt er snel een officiële aankondiging.',
        'Ik ben nog niet helemaal overtuigd, maar het idee heeft potentieel.',
        'Bedankt om dit met de community te delen!',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $locale = fake()->randomElement(['en', 'nl']);

        return $this->forLocale($locale);
    }

    /**
     * Generate a comment in the given locale.
     */
    public function forLocale(string $locale): array
    {
        $bodies = match ($locale) {
            'nl' => self::DUTCH_BODIES,
            default => self::ENGLISH_BODIES,
        };

        return [
            'locale' => $locale,
            'body' => fake()->randomElement($bodies),
        ];
    }
}