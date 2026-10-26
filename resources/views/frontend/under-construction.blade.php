<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>{{ config('app.name') }} | {{ __('general.site_tagline') }}</title>
    <meta name="description" content="{{ __('general.site_meta_description') }}">
    <meta name="keywords" content="{{ __('general.site_meta_keywords') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}" />
    <meta name="apple-mobile-web-app-title" content="{{ $seo['title'] ?? 'PkmnNexus' }}" />
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}" />
    <meta name="theme-color" content="#ffffff">
    <meta name="theme-color" content="#0f172a" media="(prefers-color-scheme: dark)">
    @vite(['resources/css/app.css', 'resources/scss/app.scss', 'resources/js/app.js'])

</head>
<body class="min-h-screen flex flex-col">

    <main class="flex-1">

        <section class="max-w-xl xl:max-w-2xl px-5 mx-auto mt-16 under-development">

            <figure>

                <img src="{{ asset('images/PkmnNexus-Logo.svg') }}" alt="{{ __('general.site_logo_alt') }}" />

            </figure>

            <h1 class="mt-5">{{ __('general.under_development_heading') }}</h1>

            <p>{{ __('general.under_development_intro') }}</p>
            <p>{{ __('general.under_development_details') }}</p>

            <x-social-media />

        </section>

    </main>

</body>
</html>