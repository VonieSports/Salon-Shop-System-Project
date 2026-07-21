<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full overflow-hidden scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config('app.name') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
         @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
    /* Force Inter font and fix readability */
    *:not(i):not([class*="fa-"]) {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif !important;
    }
    
    body, .font-sans {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif !important;
    }
    
    /* Make all text more readable */
    .text-xs {
        font-size: 0.75rem !important;
        font-weight: 500 !important;
        letter-spacing: 0.01em !important;
    }
    
    .text-sm {
        font-size: 0.875rem !important;
        font-weight: 400 !important;
        letter-spacing: 0.01em !important;
        line-height: 1.5 !important;
    }
    
    .text-base {
        font-size: 1rem !important;
        font-weight: 400 !important;
        line-height: 1.6 !important;
    }
    
    /* Headings - tighten */
    h1, h2, h3, .text-xl, .text-2xl, .text-3xl {
        letter-spacing: -0.025em !important;
        line-height: 1.2 !important;
    }
    
    /* Better contrast */
    .text-gray-400 { color: #9CA3AF !important; }
    .text-gray-500 { color: #6B7280 !important; }
    .text-gray-600 { color: #4B5563 !important; }
    .text-gray-700 { color: #374151 !important; }
    
    /* Labels */
    label, .label, .uppercase.tracking-wider {
        font-size: 0.7rem !important;
        font-weight: 600 !important;
        letter-spacing: 0.04em !important;
        color: #6B7280 !important;
    }
</style>
    @endif
        @livewireStyles
    </head>
    <body class="bg-gray-50 font-sans antialiased h-full overflow-hidden scroll-smooth" x-data="{ sidebarOpen: false }">
        <div class="flex h-screen overflow-hidden">
            <div class="fixed inset-0 bg-black/40 z-40 lg:hidden"
                 x-show="sidebarOpen"
                 x-transition:enter="transition-opacity duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="sidebarOpen = false"></div>
            @include('layouts.salon_owner.sidebar')

            <div class="flex flex-col flex-1 min-w-0 h-screen overflow-hidden">
                @include('layouts.salon_owner.header')
                <main class="overflow-y-auto p-0 lg:p-6 scrollbar-hide">
                    {{ $slot }}
                </main>
            </div>
        </div>
        @livewireScripts
        <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    </body>
</html>