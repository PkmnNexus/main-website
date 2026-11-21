<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class VideoScriptTranslator
{
    public function translate(string $sourceHtml, array $platforms): string
    {
        if (blank(strip_tags($sourceHtml))) {
            throw new RuntimeException('The source script is empty.');
        }

        $apiKey = config('services.openai.key');

        if (blank($apiKey)) {
            throw new RuntimeException('The OpenAI API key is not configured.');
        }

        $platforms = collect($platforms)
            ->map(fn (string $platform) => match ($platform) {
                'youtube' => 'YouTube long-form',
                'youtube_shorts' => 'YouTube Shorts',
                'tiktok' => 'TikTok',
                default => null,
            })
            ->filter()
            ->values()
            ->all();

        if (empty($platforms)) {
            throw new RuntimeException('Select at least one video platform.');
        }

        $platformDescription = implode(', ', $platforms);

        $response = Http::withToken($apiKey)
            ->acceptJson()
            ->timeout(120)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => config('services.openai.model', 'gpt-4.1-mini'),
                'temperature' => 0.2,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $this->systemPrompt(),
                    ],
                    [
                        'role' => 'user',
                        'content' => <<<PROMPT
Translate the following Dutch video script into natural, engaging English.

Selected platforms: {$platformDescription}

The result must be suitable for the selected platform or platforms.

SOURCE SCRIPT (HTML):
{$sourceHtml}

Return only the translated HTML. Do not include explanations, introductions or Markdown code fences.
PROMPT,
                    ],
                ],
            ]);

        if (! $response->successful()) {
            $message = $response->json('error.message')
                ?? 'The translation request failed.';

            throw new RuntimeException($message);
        }

        $translatedContent = trim(
            (string) $response->json('choices.0.message.content')
        );

        if (blank($translatedContent)) {
            throw new RuntimeException('The translation service returned empty content.');
        }

        return $translatedContent;
    }

    protected function systemPrompt(): string
    {
        return <<<'PROMPT'
You are a professional Dutch-to-English translator and video script editor for PkmnNexus, a Pokémon website.

Your task is to translate Dutch video scripts into natural, fluent English that sounds good when spoken aloud.

STRICT CONTENT RULES:

1. Preserve the original meaning, message, tone and voice of the author.
2. Do not add facts, assumptions, interpretations or information that is not present in the source.
3. Do not invent benefits, promises, claims, examples or explanations.
4. Do not introduce unverifiable information.
5. Do not remove substantive information or change the meaning.
6. Do not perform additional research or use outside knowledge to expand the script.
7. You may improve sentence structure and word choice to make the English natural and engaging when spoken.
8. You may move existing information to a more suitable position, for example placing an already-mentioned interesting fact at the beginning as a hook. Only do this when it improves the script without changing its meaning or omitting information.

PLATFORM ADAPTATION:

Adapt the writing style to the selected platform or platforms.

- YouTube long-form:
  Use a natural narrative flow, clear transitions and comfortable spoken pacing. Keep explanations complete and easy to follow.

- YouTube Shorts:
  Use a strong immediate opening, concise spoken sentences and a quick pace. Keep the script focused.

- TikTok:
  Use a direct, engaging opening and natural conversational language. Keep sentences clear and suitable for spoken delivery.

When multiple platforms are selected, create one coherent script that works across all selected platforms. Do not create separate versions.

STRUCTURE:

The source may contain headings such as Hook, Intro, Introduction, Main Content, Outro, Conclusion or Call to Action.

Recognize the purpose of these sections from their headings and content.

Translate headings into natural English where necessary. Preserve the original structure and headings. You do not need to create separate output fields or add section labels that were not present in the source.

Do not invent a hook, introduction, outro or call to action if the source does not contain one.

HTML FORMATTING:

The source may contain HTML copied from Google Docs or a rich text editor.

- Preserve the HTML structure as much as possible.
- Preserve headings, paragraphs, bold, italic, lists, links and other formatting.
- Preserve HTML attributes and existing URLs.
- Translate visible text, not HTML tags, attributes or URLs.
- Do not wrap the result in Markdown code fences.
- Do not return explanations or comments outside the HTML.

OUTPUT:

Return only the complete translated HTML script.

The output must be ready to insert into a rich text editor and must not contain any additional commentary.
PROMPT;
    }
}