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
        $articles = [
            [
                'title' => [
                    'en' => 'Community Day Guide: Best Pokémon to Catch This Month',
                    'nl' => 'Community Day-gids: De beste Pokémon om deze maand te vangen',
                ],
                'excerpt' => [
                    'en' => 'Discover detailed strategies and insights to improve your Pokémon gameplay across all modes and events.',
                    'nl' => 'Ontdek handige strategieën en tips om je Pokémon-gameplay tijdens alle spelmodi en evenementen te verbeteren.',
                ],
                'summary' => [
                    'en' => 'A complete guide to Pokémon GO events, encounters, bonuses and strategies for Trainers.',
                    'nl' => 'Een complete gids voor Pokémon GO-evenementen, ontmoetingen, bonussen en strategieën voor Trainers.',
                ],
                'content' => [
                    'en' => '
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
                            to encounter Pokémon and potentially add a rare variant to your collection.
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

                        <h3>Preparing your raid team</h3>

                        <p>
                            Building an effective raid team starts with understanding the weaknesses of the
                            raid boss. For example, a Water-type Pokémon may be vulnerable to Electric- and
                            Grass-type attacks, while a Dragon-type Pokémon can have different weaknesses
                            depending on its secondary typing.
                        </p>

                        <h2>Research and rewards</h2>

                        <p>
                            Special Research and Field Research can provide additional encounters and rewards
                            throughout an event. Always check the requirements of a research task before
                            completing it, as some objectives may be easier to finish in specific locations
                            or during particular parts of the event.
                        </p>

                        <h2>Playing with other Trainers</h2>

                        <p>
                            Pokémon GO is often more enjoyable when played together. Raids, Party Play, and
                            trading can give Trainers additional reasons to meet up and explore their local
                            area.
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
                    'nl' => '
                        <p>
                            Pokémon GO blijft Trainers over de hele wereld nieuwe ontdekkingen bieden.
                            Nieuwe Pokémon, seizoensgebonden evenementen, raids en speciaal onderzoek
                            veranderen regelmatig de manier waarop spelers het spel ontdekken.
                            Of je nu een beginnende Trainer bent of al jarenlang speelt,
                            er valt altijd iets nieuws te ontdekken.
                        </p>

                        <h2>Wat kun je verwachten van het nieuwste Pokémon GO-evenement?</h2>

                        <p>
                            Het nieuwste evenement introduceert verschillende bonussen en ontmoetingen
                            die Trainers aanmoedigen om eropuit te gaan. Tijdens het evenement verschijnen
                            bepaalde Pokémon vaker in het wild, terwijl andere beschikbaar kunnen worden
                            via raids of onderzoek.
                        </p>

                        <p>
                            Houd ook je ogen open voor <strong>Shiny Pokémon</strong>. Hoewel Shiny-
                            ontmoetingen nooit gegarandeerd zijn, kunnen evenementbonussen je meer kansen
                            geven om Pokémon tegen te komen en een zeldzame variant aan je verzameling
                            toe te voegen.
                        </p>

                        <h3>Evenementbonussen</h3>

                        <ul>
                            <li>Meer Pokémon-ontmoetingen in het wild</li>
                            <li>Extra beloningen voor geselecteerde onderzoekstaken</li>
                            <li>Bonuservaring en Stardust</li>
                            <li>Speciale raid-ontmoetingen</li>
                            <li>Meer kansen om geselecteerde Shiny Pokémon te vinden</li>
                        </ul>

                        <h2>Op welke Pokémon moet je letten?</h2>

                        <p>
                            Sommige Pokémon zijn tijdens het evenement extra interessant vanwege hun
                            beschikbaarheid, evolutievereisten of hun bruikbaarheid in gevechten.
                            Trainers die hun verzameling willen uitbreiden, zorgen er best voor dat ze
                            voldoende Poké Balls en opslagruimte hebben voordat ze op pad gaan.
                        </p>

                        <h3>Je raidteam voorbereiden</h3>

                        <p>
                            Een effectief raidteam samenstellen begint met inzicht in de zwakke punten
                            van de raidbaas. Een Water-Pokémon kan bijvoorbeeld kwetsbaar zijn voor
                            Electric- en Grass-aanvallen. Een Dragon-Pokémon kan afhankelijk van zijn
                            tweede type andere zwakke punten hebben.
                        </p>

                        <h2>Onderzoek en beloningen</h2>

                        <p>
                            Speciaal onderzoek en Field Research kunnen tijdens een evenement extra
                            ontmoetingen en beloningen opleveren. Controleer altijd de vereisten van
                            een onderzoekstaak voordat je eraan begint. Sommige opdrachten zijn
                            gemakkelijker uit te voeren op specifieke locaties of momenten.
                        </p>

                        <h2>Samen spelen met andere Trainers</h2>

                        <p>
                            Pokémon GO is vaak leuker wanneer je samen speelt. Raids, Party Play en
                            ruilen geven Trainers extra redenen om elkaar te ontmoeten en hun omgeving
                            te verkennen.
                        </p>

                        <h3>Veilig spelen</h3>

                        <p>
                            Let altijd goed op je omgeving wanneer je Pokémon GO speelt. Gebruik je
                            telefoon niet tijdens het oversteken, respecteer privéterrein en volg de
                            lokale regels wanneer je parken, bezienswaardigheden en andere openbare
                            plaatsen bezoekt.
                        </p>

                        <hr>

                        <h2>Tot slot</h2>

                        <p>
                            Of je nu op zoek bent naar een nieuwe Shiny, je voorbereidt op een moeilijke
                            raid of gewoon je buurt verkent: Pokémon GO-evenementen bieden volop kansen
                            om iets nieuws te ontdekken. Door je goed voor te bereiden en te weten wat
                            je kunt verwachten, haal je meer uit je speeltijd.
                        </p>

                        <p>
                            <strong>Veel succes, Trainers, en veel vangplezier!</strong>
                        </p>
                    ',
                ],
            ],
            [
                'title' => [
                    'en' => 'How to Prepare for Upcoming Raid Events in Pokémon GO',
                    'nl' => 'Zo bereid je je voor op aankomende raid-evenementen in Pokémon GO',
                ],
                'excerpt' => [
                    'en' => 'A complete breakdown of raid preparation, counters and optimization tips for Pokémon GO.',
                    'nl' => 'Een compleet overzicht van raidvoorbereidingen, counters en handige optimalisatietips voor Pokémon GO.',
                ],
                'summary' => [
                    'en' => 'Learn how to prepare your Pokémon, items and raid teams before the next major event.',
                    'nl' => 'Leer hoe je je Pokémon, items en raidteams voorbereidt op het volgende grote evenement.',
                ],
                'content' => [
                    'en' => '
                        <p>
                            Raid events are an important part of Pokémon GO. With the right preparation,
                            Trainers can defeat powerful raid bosses, earn rewards and encounter rare Pokémon.
                        </p>
                        <h2>Build an effective raid team</h2>
                        <p>
                            Start by checking the raid boss and its typing. Choose Pokémon with attacks
                            that exploit its weaknesses and make sure your team has enough strength to
                            survive the battle.
                        </p>
                        <h2>Prepare your items</h2>
                        <ul>
                            <li>Revives and Max Revives</li>
                            <li>Potions and Max Potions</li>
                            <li>Remote Raid Passes where applicable</li>
                            <li>Useful berries for catching the raid boss</li>
                        </ul>
                        <h2>Coordinate with other Trainers</h2>
                        <p>
                            Larger raid groups can make difficult encounters easier. Plan your meeting
                            location and invite other Trainers before the event begins.
                        </p>
                        <p><strong>Good preparation makes every raid more rewarding!</strong></p>
                    ',
                    'nl' => '
                        <p>
                            Raid-evenementen zijn een belangrijk onderdeel van Pokémon GO. Met de juiste
                            voorbereiding kunnen Trainers krachtige raidbazen verslaan, beloningen
                            verdienen en zeldzame Pokémon tegenkomen.
                        </p>
                        <h2>Stel een effectief raidteam samen</h2>
                        <p>
                            Controleer eerst de raidbaas en zijn type. Kies Pokémon met aanvallen die
                            zijn zwakke punten benutten en zorg ervoor dat je team sterk genoeg is
                            om het gevecht te overleven.
                        </p>
                        <h2>Bereid je items voor</h2>
                        <ul>
                            <li>Revives en Max Revives</li>
                            <li>Potions en Max Potions</li>
                            <li>Remote Raid Passes indien van toepassing</li>
                            <li>Handige Berries om de raidbaas te vangen</li>
                        </ul>
                        <h2>Werk samen met andere Trainers</h2>
                        <p>
                            Grotere raidgroepen kunnen moeilijke ontmoetingen eenvoudiger maken.
                            Spreek vooraf een ontmoetingsplaats af en nodig andere Trainers uit.
                        </p>
                        <p><strong>Een goede voorbereiding maakt iedere raid waardevoller!</strong></p>
                    ',
                ],
            ],
            [
                'title' => [
                    'en' => 'Top Meta Decks Dominating the Pokémon TCG Scene',
                    'nl' => 'De beste metadecks die de Pokémon TCG-scene domineren',
                ],
                'excerpt' => [
                    'en' => 'Explore popular competitive Pokémon TCG decks and learn what makes them effective.',
                    'nl' => 'Ontdek populaire competitieve Pokémon TCG-decks en leer waarom ze zo effectief zijn.',
                ],
                'summary' => [
                    'en' => 'An overview of competitive deck building, strategy and the current Pokémon TCG meta.',
                    'nl' => 'Een overzicht van competitieve deckbuilding, strategie en de huidige Pokémon TCG-meta.',
                ],
                'content' => [
                    'en' => '
                        <p>
                            The Pokémon Trading Card Game continues to evolve as new cards and strategies
                            enter the competitive scene. Understanding the current meta can help players
                            make better decisions when building a deck.
                        </p>
                        <h2>Understanding the competitive meta</h2>
                        <p>
                            A strong deck combines reliable Pokémon, useful Trainer cards and a consistent
                            Energy strategy. The best lists are designed to perform well against several
                            different matchups.
                        </p>
                        <h2>Improve your deck</h2>
                        <ul>
                            <li>Keep your strategy focused</li>
                            <li>Use consistent draw support</li>
                            <li>Prepare for common matchups</li>
                            <li>Test your deck against different opponents</li>
                        </ul>
                        <p><strong>Practice and preparation are essential for competitive play.</strong></p>
                    ',
                    'nl' => '
                        <p>
                            De Pokémon Trading Card Game blijft veranderen wanneer nieuwe kaarten en
                            strategieën hun intrede doen in de competitieve scene. Inzicht in de huidige
                            meta helpt spelers betere keuzes te maken bij het bouwen van een deck.
                        </p>
                        <h2>De competitieve meta begrijpen</h2>
                        <p>
                            Een sterk deck combineert betrouwbare Pokémon, nuttige Trainer-kaarten en
                            een consistente Energy-strategie. De beste decklijsten zijn ontworpen om
                            tegen verschillende tegenstanders goed te presteren.
                        </p>
                        <h2>Verbeter je deck</h2>
                        <ul>
                            <li>Houd je strategie duidelijk en gericht</li>
                            <li>Gebruik betrouwbare kaarten om kaarten te trekken</li>
                            <li>Bereid je voor op veelvoorkomende matchups</li>
                            <li>Test je deck tegen verschillende tegenstanders</li>
                        </ul>
                        <p><strong>Oefening en voorbereiding zijn essentieel voor competitief spelen.</strong></p>
                    ',
                ],
            ],
        ];

        $article = $this->faker->randomElement($articles);

        $title = $article['title'];
        $slugSuffix = $this->faker->unique()->numberBetween(1000, 99999);

        return [
            // Core content
            'title' => $title,

            'slug' => [
                'en' => Str::slug($title['en']) . '-' . $slugSuffix,
                'nl' => Str::slug($title['nl']) . '-' . $slugSuffix,
            ],

            'excerpt' => $article['excerpt'],
            'summary' => $article['summary'],
            'content' => $article['content'],

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
            'meta_title' => [
                'en' => $title['en'],
                'nl' => $title['nl'],
            ],

            'meta_description' => [
                'en' => $article['excerpt']['en'],
                'nl' => $article['excerpt']['nl'],
            ],

            'meta_keywords' => [
                'en' => [
                    'Pokémon GO',
                    'Pokémon',
                    'Gaming',
                    'Events',
                    'Guides',
                ],
                'nl' => [
                    'Pokémon GO',
                    'Pokémon',
                    'Games',
                    'Evenementen',
                    'Gidsen',
                ],
            ],

            'canonical' => [
                'en' => null,
                'nl' => null,
            ],

            'robots_index' => true,
            'robots_follow' => true,

            // Open Graph
            'og_title' => [
                'en' => $title['en'],
                'nl' => $title['nl'],
            ],

            'og_description' => [
                'en' => $article['excerpt']['en'],
                'nl' => $article['excerpt']['nl'],
            ],

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
        return $this->afterCreating(function (Article $article) {
            $tags = collect([
                ['en' => 'Pokémon GO', 'nl' => 'Pokémon GO'],
                ['en' => 'Pokémon Scarlet & Violet', 'nl' => 'Pokémon Scarlet & Violet'],
                ['en' => 'Pokémon Legends: Z-A', 'nl' => 'Pokémon Legends: Z-A'],
                ['en' => 'Pokémon TCG', 'nl' => 'Pokémon TCG'],
                ['en' => 'Pokémon Unite', 'nl' => 'Pokémon Unite'],
                ['en' => 'Pokémon Sleep', 'nl' => 'Pokémon Sleep'],
                ['en' => 'Nintendo Switch', 'nl' => 'Nintendo Switch'],
                ['en' => 'Mobile Games', 'nl' => 'Mobiele games'],

                ['en' => 'New Releases', 'nl' => 'Nieuwe releases'],
                ['en' => 'Game Updates', 'nl' => 'Game-updates'],
                ['en' => 'Patch Notes', 'nl' => 'Patch notes'],
                ['en' => 'Events', 'nl' => 'Evenementen'],
                ['en' => 'Community Day', 'nl' => 'Community Day'],
                ['en' => 'Special Research', 'nl' => 'Speciaal onderzoek'],
                ['en' => 'Giveaways', 'nl' => 'Winacties'],
                ['en' => 'Announcements', 'nl' => 'Aankondigingen'],

                ['en' => 'Shiny Pokémon', 'nl' => 'Shiny Pokémon'],
                ['en' => 'Legendary Pokémon', 'nl' => 'Legendarische Pokémon'],
                ['en' => 'Mythical Pokémon', 'nl' => 'Mythische Pokémon'],
                ['en' => 'Mega Evolution', 'nl' => 'Mega-evolutie'],
                ['en' => 'Regional Forms', 'nl' => 'Regionale vormen'],
                ['en' => 'Evolution', 'nl' => 'Evolutie'],
                ['en' => 'New Pokémon', 'nl' => 'Nieuwe Pokémon'],

                ['en' => 'Battle Strategy', 'nl' => 'Gevechtsstrategie'],
                ['en' => 'PvP', 'nl' => 'PvP'],
                ['en' => 'Raid Battles', 'nl' => 'Raidgevechten'],
                ['en' => 'Team Building', 'nl' => 'Team samenstellen'],
                ['en' => 'Tier List', 'nl' => 'Tierlijst'],
                ['en' => 'Competitive Play', 'nl' => 'Competitief spelen'],
                ['en' => 'Tips & Tricks', 'nl' => 'Tips & trucs'],
                ['en' => 'Beginner Guides', 'nl' => 'Beginnersgidsen'],

                ['en' => 'Trading Card Game', 'nl' => 'Ruilkaartspel'],
                ['en' => 'Booster Packs', 'nl' => 'Boosterpacks'],
                ['en' => 'Card Collections', 'nl' => 'Kaartenverzamelingen'],
                ['en' => 'Deck Building', 'nl' => 'Deck bouwen'],
                ['en' => 'Card Reveals', 'nl' => 'Kaartonthullingen'],
                ['en' => 'TCG Pocket', 'nl' => 'TCG Pocket'],

                ['en' => 'Ash Ketchum', 'nl' => 'Ash Ketchum'],
                ['en' => 'Anime', 'nl' => 'Anime'],
                ['en' => 'Pokémon Horizons', 'nl' => 'Pokémon Horizons'],
                ['en' => 'Merchandise', 'nl' => 'Merchandise'],
                ['en' => 'Pokémon News', 'nl' => 'Pokémonnieuws'],
            ])
                ->random($this->faker->numberBetween(2, 4))
                ->map(function (array $translations) {
                    $tag = \App\Models\Tag::firstOrCreate(
                        [
                            'slug' => \Illuminate\Support\Str::slug($translations['en']),
                        ],
                        [
                            'name' => $translations,
                        ],
                    );

                    foreach ($translations as $locale => $name) {
                        $tag->setTranslation('name', $locale, $name);
                    }

                    $tag->save();

                    return $tag;
                });

            $article->syncTags($tags);
        });
    }
}