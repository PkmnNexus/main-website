<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>{{ config('app.name') }} | Your source for Pokémon news, TCG, GO and game updates.</title>
    <meta name="description" content="Stay up to date with the latest Pokémon news, Pokémon TCG releases, Pokémon GO events, game updates, guides, leaks, and community content. Discover everything Pokémon on PkmnNexus.">
    <meta name="keywords" content="Pokémon, Pokémon News, Pokémon TCG, Pokémon GO, Pokémon Games, Scarlet & Violet, Pokémon Legends, Nintendo Switch, Pokémon Trading Card Game, Pokémon Events, Pokémon Leaks, Pokémon Guides, Pokémon Community, Pokémon Cards, Pokémon Updates">
    <link rel="icon" type="image/png" href="{{ asset('favicon/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}" />
    <meta name="apple-mobile-web-app-title" content="{{ $seo['title'] ?? 'PkmnInsider' }}" />
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}" />
    <meta name="theme-color" content="#ffffff">
    <meta name="theme-color" content="#0f172a" media="(prefers-color-scheme: dark)">
    @vite(['resources/css/app.css', 'resources/scss/app.scss', 'resources/js/app.js'])

</head>
<body class="min-h-screen flex flex-col">
    
    <main class="flex-1">

        <section class="max-w-xl xl:max-w-2xl px-5 mx-auto mt-16 under-development">

            <figure>
                <img src="{{ asset('images/PkmnNexus-Logo.svg') }}"  alt="PkmnNexus Logo" />
            </figure>

            <h1 class="mt-5 mb-5">Welcome to PkmnNexus!</h1>

            <p>PkmnNexus is currently under development, but we're working hard to bring you a place where every Pokémon fan feels at home.</p>
            <p>Once we launch, you'll find the latest Pokémon TCG news and set releases, Pokémon GO event coverage, and updates on the newest Pokémon video games. We're also preparing pack openings and pack rips, videos, guides, articles, and much more to keep you up to date with everything happening in the Pokémon world.</p>

            <x-social-media />

        </section>

    </main>

</body>
</html>