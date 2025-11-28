<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @if (app()->environment('local'))
            {{-- In local/dev mode include Vite dev server scripts directly to avoid manifest checks. --}}
            {{-- Use an env-driven dev URL so teams can override the dev host/port if needed. --}}
            @php
                // Default to localhost:5173 when VITE_DEV_URL is not set.
                $viteDevUrl = rtrim(env('VITE_DEV_URL', 'http://localhost:5173'), '/');
            @endphp
            <script type="module" src="{{ $viteDevUrl }}/@@vite/client"></script>
            <script type="module" src="{{ $viteDevUrl }}/resources/js/app.js"></script>
            @isset($page['component'])
                <script type="module" src="{{ $viteDevUrl }}/resources/js/Pages/{{ $page['component'] }}.vue"></script>
            @endisset
        @else
            @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @endif
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
