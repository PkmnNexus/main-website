<?php

namespace App\View\Components\Articles;

use App\Models\Article;
use App\Models\PokemonTcgCard;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;
use Illuminate\View\View;
use Throwable;

class CardGallery extends Component
{
    public ?Article $article;

    public Collection $cards;

    public function __construct(?Article $article = null)
    {
        $this->article = $article;
        $this->cards = new Collection();

        if (! $article || ! $article->exists || ! $article->getKey()) {
            return;
        }

        try {
            $this->cards = PokemonTcgCard::query()
                ->with('set')
                ->whereIn(
                    'set_id',
                    $article->pokemonTcgSets()->select('pokemon_tcg_sets.id'),
                )
                ->orderBy('api_local_id')
                ->get();
        } catch (Throwable $exception) {
            report($exception);
        }
    }

    public function render(): View
    {
        return view('components.articles.card-gallery');
    }
}