<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class ArticleMetadataGenerator
{
    public function generate(
        string $title,
        string $excerpt,
        string $content,
        array $keywords = [],
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

                            Generate SEO metadata for the supplied article.

                            Requirements:
                            - Write all metadata in English.
                            - Use only information supported by the article.
                            - Use official English names for Pokémon, games, characters, and locations.
                            - Create a clear, descriptive meta title, ideally no longer than 60 characters.
                            - Create a useful meta description, ideally no longer than 160 characters.
                            - Avoid keyword stuffing and clickbait.
                            - Do not invent facts, dates, or announcements.
                            - Do not claim to know current search trends or search volumes.
                            - The Open Graph title and description should be identical to the SEO title and description.
                            - Return only valid JSON in this format:

                            {
                            "meta_title": "...",
                            "meta_description": "..."
                            }
                            PROMPT,
                    ],
                    [
                        'role' => 'user',
                        'content' => json_encode([
                            'title' => $title,
                            'excerpt' => $excerpt,
                            'content' => $content,
                            'keywords' => $keywords,
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

        $metaTitle = trim($result['meta_title'] ?? '');
        $metaDescription = trim($result['meta_description'] ?? '');

        if ($metaTitle === '' || $metaDescription === '') {
            throw new RuntimeException(
                'AI heeft geen geldige meta title en description teruggegeven.'
            );
        }

        return [
            'meta_title' => mb_substr($metaTitle, 0, 60),
            'meta_description' => mb_substr($metaDescription, 0, 160),
        ];
    }
}