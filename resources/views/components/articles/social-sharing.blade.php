<div class="mt-8 border-t border-[#F0F0F0] pt-5">

    <div class="flex flex-wrap items-center gap-3">

        <span class="font-display text-sm font-bold text-[var(--color-secondary)]">Share this article</span>

        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('article.show', ['category' => $article->category->slug, 'slug' => $article->slug])) }}"
           target="_blank"
           rel="noopener noreferrer"
           aria-label="Share on Facebook"
           class="inline-flex h-10 w-10 items-center justify-center rounded-md bg-[#F5F5F5] text-[var(--color-secondary)] transition hover:bg-[var(--color-primary)] hover:text-white">

            <svg xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 24 24"
                 fill="currentColor"
                 class="h-5 w-5"
                 aria-hidden="true">

                <path d="M13.5 21v-8.2h2.8l.4-3.2h-3.2V7.5c0-.9.3-1.5 1.6-1.5h1.7V3.1c-.3 0-1.4-.1-2.6-.1-2.6 0-4.4 1.6-4.4 4.5v2.1H7v3.2h2.8V21h3.7Z"/>

            </svg>

        </a>

        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('article.show', ['category' => $article->category->slug, 'slug' => $article->slug])) }}&text={{ urlencode($article->title) }}"
           target="_blank"
           rel="noopener noreferrer"
           aria-label="Share on X"
           class="inline-flex h-10 w-10 items-center justify-center rounded-md bg-[#F5F5F5] text-[var(--color-secondary)] transition hover:bg-[var(--color-primary)] hover:text-white">

            <svg xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 24 24"
                 fill="currentColor"
                 class="h-4 w-4"
                 aria-hidden="true">

                <path d="M18.9 2H22l-6.8 7.8L23.2 22h-6.3l-4.9-7.4L5.5 22H2.3l7.3-8.4L1.8 2h6.5l4.4 6.9L18.9 2Zm-1.1 18h1.7L7.3 3.9H5.5L17.8 20Z"/>

            </svg>

        </a>

        <a href="https://www.reddit.com/submit?url={{ urlencode(route('article.show', ['category' => $article->category->slug, 'slug' => $article->slug])) }}&title={{ urlencode($article->title) }}"
           target="_blank"
           rel="noopener noreferrer"
           aria-label="Share on Reddit"
           class="inline-flex h-10 w-10 items-center justify-center rounded-md bg-[#F5F5F5] text-[var(--color-secondary)] transition hover:bg-[var(--color-primary)] hover:text-white">

            <svg xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 24 24"
                 fill="currentColor"
                 class="h-5 w-5"
                 aria-hidden="true">

                <path d="M12 2a2 2 0 0 0-1.9 2.6l-3.2 1a2.5 2.5 0 1 0-1.6 4.5 5.2 5.2 0 0 0-.1 1c0 3.3 3 5.9 6.8 5.9s6.8-2.6 6.8-5.9a5.2 5.2 0 0 0-.1-1 2.5 2.5 0 1 0-1.6-4.5l-3.2-1A2 2 0 0 0 12 2Zm-4.2 8.1a1.2 1.2 0 1 1 0 2.4 1.2 1.2 0 0 1 0-2.4Zm8.4 0a1.2 1.2 0 1 1 0 2.4 1.2 1.2 0 0 1 0-2.4ZM8.7 14.3a5.1 5.1 0 0 0 6.6 0 .6.6 0 0 1 .8.9 6.3 6.3 0 0 1-8.2 0 .6.6 0 0 1 .8-.9Z" transform="translate(0 2)"/>
            
            </svg>

        </a>

        <a href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' ' . route('article.show', ['category' => $article->category->slug, 'slug' => $article->slug])) }}"
           target="_blank"
           rel="noopener noreferrer"
           aria-label="Share on WhatsApp"
           class="inline-flex h-10 w-10 items-center justify-center rounded-md bg-[#F5F5F5] text-[var(--color-secondary)] transition hover:bg-[var(--color-primary)] hover:text-white">

            <svg xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 24 24"
                 fill="currentColor"
                 class="h-5 w-5"
                 aria-hidden="true">
                 
                <path d="M12 2a9.8 9.8 0 0 0-8.4 14.9L2.4 22l5.2-1.2A9.9 9.9 0 1 0 12 2Zm0 17.9a8 8 0 0 1-4.1-1.1l-.3-.2-3.1.7.7-3-.2-.3A8 8 0 1 1 12 19.9Zm4.4-6c-.2-.1-1.4-.7-1.6-.8-.2-.1-.4-.1-.5.1-.2.2-.6.8-.8.9-.1.2-.3.2-.5.1-.2-.1-.9-.3-1.8-1.1-.7-.6-1.1-1.3-1.2-1.5-.1-.2 0-.3.1-.5l.4-.4.2-.4c.1-.2 0-.3 0-.4l-.7-1.7c-.2-.4-.4-.4-.5-.4h-.5c-.2 0-.4.1-.6.3-.2.2-.8.8-.8 1.9s.8 2.2.9 2.4c.1.2 1.6 2.5 3.8 3.4.5.2.9.3 1.2.4.5.2 1 .1 1.4.1.4-.1 1.4-.6 1.6-1.1.2-.5.2-1 .1-1.1-.1-.1-.2-.2-.4-.3Z"/>
            
            </svg>

        </a>

    </div>

</div>