@if($seo)
    <title>{{ $seo['title'] }} | {{ config('app.name') }}</title>
    <meta name="description" content="{{ $seo['description'] }}">
    <meta name="keywords" content="{{ $seo['keywords'] }}">
    <meta name="robots" content="{{ $seo['robots'] }}">
    <link rel="canonical" href="{{ $seo['canonical'] }}">

    <meta property="og:title" content="{{ $seo['og_title'] }}">
    <meta property="og:description" content="{{ $seo['og_description'] }}">
    <meta property="og:type" content="{{ $seo['og_type'] }}">
    <meta property="og:locale" content="en_US">
    <meta property="og:url" content="{{ $seo['canonical'] }}">
    <meta property="og:site_name" content="PkmnInsider">
    <meta property="og:image" content="{{ $seo['image'] }}">
    <meta property="og:image:alt" content="{{ $seo['og_title'] }}">

    @if($seo['og_type'] === 'article')
        <meta property="article:published_time" content="{{ $seo['published_time'] }}">
        @if($seo['published_time'] != $seo['modified_time'])
            <meta property="article:modified_time" content="{{ $seo['modified_time'] }}">
        @endif
    @endif

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image:alt" content="{{ $seo['og_title'] }}">
    <meta name="twitter:title" content="{{ $seo['title'] }}">
    <meta name="twitter:description" content="{{ $seo['description'] }}">
    <meta name="twitter:image" content="{{ $seo['image'] }}">
    <meta name="twitter:site" content="@pkmninsider">
    <meta name="twitter:creator" content="@pkmninsider">

    <link rel="icon" type="image/png" href="{{ asset('favicon/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}" />
    <meta name="apple-mobile-web-app-title" content="{{ $seo['title'] ?? 'PkmnInsider' }}" />
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}" />
    <meta name="theme-color" content="#ffffff">
    <meta name="theme-color" content="#0f172a" media="(prefers-color-scheme: dark)">
@endif

@if(!empty($jsonLd))
    <script type="application/ld+json">
        {!! json_encode($jsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endif