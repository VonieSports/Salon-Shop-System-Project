<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class=" bg-white text-gray-800  antialiased dark-transition">
    @if(!request()->routeIs('admin.login') && !request()->routeIs('admin.*'))
    @include('layouts.public.header')
    @endif

    <main>
        {{ $slot }}
    </main>

    @if(!request()->routeIs('admin.login') && !request()->routeIs('admin.*'))
    @include('layouts.public.footer')
    @endif

    @livewireScripts
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script src="./node_modules/preline/dist/preline.js"></script>
</body>

</html>