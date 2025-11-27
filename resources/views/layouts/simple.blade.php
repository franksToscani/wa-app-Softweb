<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title', config('app.name', 'Laravel'))</title>

  {{-- Include a page-specific CSS bundle only (no app.js) so Vue/PrimeVue won't be loaded --}}
  {{-- Use Vite to load the page CSS (dev HMR when running `npm run dev`).
      This keeps the Blade page in sync with the rest of the app during development. --}}
  {{-- Load page CSS via Vite. Ensure the dev server or a built manifest is available when rendering. --}}
  @vite(['resources/css/admin-posts.css'])

  {{-- Allow pages to inject extra head styles/scripts --}}
  @stack('head')
</head>
<body class="font-sans antialiased">
  @yield('content')
</body>
</html>
