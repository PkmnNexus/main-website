<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class ArticleKeywordGenerator
{
    public function generate(
        string $title,
        string $excerpt,
        string $content,
        ?string $category = null,
    ): array {
        $apiKey = config('services.openai.key');

        if (blank($apiKey)) {
            throw new RuntimeException(
                'De OpenAI API-key ontbreekt in de configuratie.'
            );
        }

        $response = Http::withToken($apiKey)
            ->acceptJson()
            ->timeout(60)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => config(
                    'services.openai.model',
                    'gpt-4.1-mini'
                ),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => <<<'PROMPT'
You are an SEO specialist for an English-language Pokémon news website.

Analyze the supplied article and generate relevant SEO keywords.

Rules:
- Return all keywords in English.
- Use official English names for Pokémon, games, characters, locations, and features.
- Preserve official names that are not translated.
- Base keywords only on information supported by the article.
- Include a mix of primary keywords, related terms, and specific long-tail search phrases.
- Avoid duplicates, irrelevant terms, and overly broad keywords.
- Do not invent search volumes, popularity data, or trends.
- Return 5 to 12 keywords.
- Return only valid JSON in this format:
  {"keywords": ["keyword 1", "keyword 2"]}
PROMPT,
                    ],
                    [
                        'role' => 'user',
                        'content' => json_encode([
                            'title' => $title,
                            'excerpt' => $excerpt,
                            'content' => $content,
                            'category' => $category,
                        ], JSON_UNESCAPED_UNICODE),
                    ],
                ],
                'response_format' => [
                    'type' => 'json_object',
                ],
                'temperature' => 0.4,
            ])
            ->throw()
            ->json();

        $content = data_get(
            $response,
            'choices.0.message.content'
        );

        if (! is_string($content)) {
            throw new RuntimeException(
                'AI heeft geen geldige response teruggegeven.'
            );
        }

        $result = json_decode($content, true);

        $keywords = $result['keywords'] ?? null;

        if (! is_array($keywords)) {
            throw new RuntimeException(
                'AI heeft geen geldige keywords-lijst teruggegeven.'
            );
        }

        return collect($keywords)
            ->filter(fn ($keyword) => is_string($keyword))
            ->map(fn ($keyword) => trim($keyword))
            ->filter()
            ->unique(fn ($keyword) => mb_strtolower($keyword))
            ->take(12)
            ->values()
            ->all();
    }
}