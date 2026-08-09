<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50 font-['Inter'] antialiased overflow-x-hidden"
      x-data="{ mobileMenuOpen: false, searchOpen: false }">
    <header class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200 shadow-sm">
        @include('layouts.customer.header')
    </header>

    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden"
         x-show="mobileMenuOpen"
         x-transition:enter="opacity-0"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="opacity-100"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileMenuOpen = false">
    </div>

    <div class="fixed top-0 left-0 w-[300px] max-w-[85vw] h-full bg-white z-50 overflow-y-auto transition-transform duration-300 ease-in-out lg:hidden"
         :class="mobileMenuOpen ? 'translate-x-0' : '-translate-x-full'">
        @include('layouts.customer.sidebar')
    </div>

    <main class="pt-[110px] sm:pt-[120px] lg:pt-[130px] min-h-screen">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>

    @livewireScripts
</body>
</html>