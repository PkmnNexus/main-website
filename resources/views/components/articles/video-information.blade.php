@if($article->youtube_published_at || $duration || filled($article->video_url))

    <section class="rounded-xl bg-white shadow-md p-6" aria-labelledby="video-information-heading">

        <h2 id="video-information-heading" class="font-display !text-2xl font-bold text-[var(--color-primary)] mb-6">Video Information</h2>

        <div class="space-y-5">

            @if($article->youtube_published_at)

                <div class="flex items-start gap-3">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mt-0.5 shrink-0 text-[var(--color-primary)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                        <rect x="3" y="4" width="18" height="17" rx="2" />
                        <path d="M16 2v4M8 2v4M3 10h18" />
                    </svg>

                    <div class="min-w-0">

                        <p class="text-sm text-[var(--color-secondary)]">Published</p>

                        <time class="font-bold text-[var(--color-primary)]" datetime="{{ $article->youtube_published_at->toIso8601String() }}">{{ $article->youtube_published_at->translatedFormat('F jS, Y') }}</time>

                    </div>

                </div>

            @endif

            @if($duration)

                <div class="flex items-start gap-3">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mt-0.5 shrink-0 text-[var(--color-primary)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                        <circle cx="12" cy="12" r="9" />
                        <path d="M12 7v5l3 2" />
                    </svg>

                    <div class="min-w-0">

                        <p class="text-sm text-[var(--color-secondary)]">Duration</p>

                        <p class="font-bold text-[var(--color-primary)]">{{ $duration }}</p>

                    </div>

                </div>

            @endif

            @if(filled($article->video_url))

                <a href="{{ $article->video_url }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center gap-2 w-full rounded-lg bg-[var(--color-primary)] px-4 py-3 text-sm font-bold text-white transition hover:bg-[var(--color-secondary)]">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.5 3.6 12 3.6 12 3.6s-7.5 0-9.4.5A3 3 0 0 0 .5 6.2 31 31 0 0 0 0 12a31 31 0 0 0 .5 5.8 3 3 0 0 0 2.1 2.1c1.9.5 9.4.5 9.4.5s7.5 0 9.4-.5a3 3 0 0 0 2.1-2.1A31 31 0 0 0 24 12a31 31 0 0 0-.5-5.8ZM9.6 15.6V8.4l6.3 3.6-6.3 3.6Z"/>
                    </svg>

                    <span>Watch on YouTube</span>

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                        <path d="M14 3h7v7M10 14 21 3M19 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h6" />
                    </svg>

                </a>

                <p class="text-xs text-center text-[var(--color-secondary)]">Open the original video on YouTube</p>

            @endif

        </div>

    </section>

@endif