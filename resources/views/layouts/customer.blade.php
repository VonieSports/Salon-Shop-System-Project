<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50 font-['Inter'] antialiased"
      x-data="{ sidebarOpen: window.innerWidth >= 1024, searchOpen: false }"
      @resize.window="sidebarOpen = window.innerWidth >= 1024">
    <header class="relative fixed top-0 left-0 right-0 z-40 bg-white border-b border-gray-100 h-16 lg:h-[72px] flex items-center px-4 lg:px-8">
        @include('layouts.customer.header')
    </header>

    <div class="flex  min-h-screen">
        <aside class="fixed left-0 top-16 lg:top-[72px] bottom-0 w-[280px] bg-white border-r border-gray-100 z-30 overflow-y-auto transition-transform duration-300 ease-in-out"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
            @include('layouts.customer.sidebar')
        </aside>

        <div class="fixed inset-0 bg-black/40 z-20 lg:hidden"
             x-show="sidebarOpen"
             x-transition:enter="transition-opacity duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false">
        </div>

        <main class="flex-1 ml-0 lg:ml-[280px] p-4 sm:p-6 lg:p-8 overflow-y-auto min-h-[calc(100vh-4rem)] lg:min-h-[calc(100vh-4.5rem)]">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>
</html>