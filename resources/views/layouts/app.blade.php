<!DOCTYPE html>

<html lang="en" itemscope itemtype="https://schema.org/WebPage">

    <head>

        @if (app()->environment('production'))

            <x-analytics.google-tag-manager />

        @endif

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <x-seo-head :pageSeo="$pageSeo ?? null" />

        @vite(['resources/css/app.css', 'resources/scss/app.scss', 'resources/js/app.js'])

        @stack('styles')

    </head>

    <body class="min-h-screen flex flex-col">

        @if (app()->environment('production'))

            <x-analytics.google-tag-manager-noscript />

        @endif

        <x-admin-dashboard-link />

        @include('frontend.partials.navigation.main')

        <main class="flex-1 page-transition" style="--main-background-image: url('{{ asset(\Illuminate\Support\Arr::random(config('appearance.main_background_images'))) }}')" itemprop="mainContentOfPage">

            {{ $slot }}

        </main>

        @include('frontend.partials.subfooter')

        @include('frontend.partials.footer')

        @livewireScripts

        <x-cookie-consent.preferences-button />
        <x-cookie-consent.banner />

    </body>

</html>