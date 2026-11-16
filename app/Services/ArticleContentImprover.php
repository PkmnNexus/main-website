<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class ArticleContentImprover
{
    /**
     * Improve the wording of an existing article without adding content.
     */
    public function improve(string $content): string
    {
        $apiKey = config('services.openai.key');

        if (blank($apiKey)) {
            throw new RuntimeException(
                'De OpenAI API-key ontbreekt in de configuratie.'
            );
        }

        if (blank($content)) {
            throw new RuntimeException(
                'There is no article content to improve.'
            );
        }

        $response = Http::withToken($apiKey)
            ->acceptJson()
            ->timeout(120)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => config(
                    'services.openai.model',
                    'gpt-4.1-mini'
                ),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => <<<'PROMPT'
You are a professional editor for a Pokémon news website.

Your task is to carefully improve the wording of an existing article.

The article is written in English. The improved version must remain in English.

IMPORTANT:
Improve the existing text only. Do not write new content.

Rules:
- Make subtle improvements to grammar, sentence structure, clarity, readability and natural phrasing.
- Preserve the original meaning, facts, information and nuance.
- Do not invent, add, remove or assume facts.
- Do not add sentences, paragraphs, explanations, examples or information.
- Do not introduce new words or phrases that add information or meaning that was not already present.
- Do not unnecessarily rewrite sentences that are already clear and correct.
- Keep the original length and structure as close to the source as possible.
- Put the most important information first where the existing content allows it.
- Write for the reader. Use a reader-focused and customer-oriented tone rather than writing from the author's perspective.
- Prefer active voice and direct, natural sentences.
- Use calls to action only when they naturally improve an existing sentence and do not introduce new information.
- Avoid excessive adjectives and unnecessary descriptive language.
- Avoid em dashes and typical AI writing patterns.
- Do not use emojis.
- Do not add headings or heading tags.
- Do not add unordered lists, ordered lists or horizontal rules.
- Do not introduce bold or italic formatting.
- Preserve all existing HTML tags, attributes, links, images, embeds and paragraph structure.
- Do not add, remove or rearrange HTML elements.
- Do not convert plain text into HTML formatting.
- Do not add Markdown formatting.
- Return only the improved HTML content.
PROMPT,
                    ],
                    [
                        'role' => 'user',
                        'content' => $content,
                    ],
                ],
                'temperature' => 0.2,
            ])
            ->throw()
            ->json();

        $improvedContent = data_get(
            $response,
            'choices.0.message.content'
        );

        if (! is_string($improvedContent) || blank($improvedContent)) {
            throw new RuntimeException(
                'AI heeft geen geldige verbeterde artikeltekst teruggegeven.'
            );
        }

        return trim($improvedContent);
    }
}