<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <x-seo-head :pageSeo="$pageSeo ?? null" />

    @vite(['resources/css/app.css', 'resources/scss/app.scss', 'resources/js/app.js'])

    @stack('structured-data')
    @stack('styles')
</head>
<body class="min-h-screen flex flex-col">
    
    @include('frontend.partials.navigation.main')

    <main class="flex-1">

        {{ $slot }}

    </main>

    @include('frontend.partials.subfooter')

    @include('frontend.partials.footer')

    @stack('scripts')

    @livewireScripts

</body>
</html>