<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class ArticleSummaryGenerator
{
    /**
     * Generate a short summary of an article.
     */
    public function generate(
        string $title,
        string $excerpt,
        string $content,
    ): string {
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
You are an editor for a professional Pokémon news website.

Write a concise summary of the provided article.

Rules:
- Write the summary in English.
- Maximum 4 sentences.
- Summarize the actual content of the article.
- Put the most important news and facts first.
- Include the most important facts, events, or conclusions.
- Do not introduce information that is not present in the article.
- Do not use bullet points.
- Do not use headings.
- Write in clear, natural American English.
- Prefer active voice and clear, direct sentences.
- Avoid unnecessary wording, repetition, and filler.
- Return only the summary text.
PROMPT,
                    ],
                    [
                        'role' => 'user',
                        'content' => json_encode([
                            'title' => $title,
                            'excerpt' => $excerpt,
                            'content' => $content,
                        ], JSON_UNESCAPED_UNICODE),
                    ],
                ],
                'temperature' => 0.4,
            ])
            ->throw()
            ->json();

        $summary = data_get(
            $response,
            'choices.0.message.content'
        );

        if (! is_string($summary)) {
            throw new RuntimeException(
                'AI heeft geen geldige summary teruggegeven.'
            );
        }

        return trim($summary);
    }
}