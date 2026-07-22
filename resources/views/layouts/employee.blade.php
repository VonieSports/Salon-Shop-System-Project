<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config('app.name') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body x-data="{ 
        sidebarOpen: window.innerWidth >= 1024,
        init() {
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) {
                    this.sidebarOpen = true;
                }
            });
            
            window.addEventListener('livewire:navigating', () => {
                if (window.innerWidth < 1024) {
                    this.sidebarOpen = false;
                }
            });
        }
    }" 
    x-init="init()" 
    class="bg-gray-100 overflow-x-hidden">
        <div class="flex h-screen overflow-hidden">
            <!-- Sidebar -->
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition ease-in-out duration-300"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 lg:relative lg:translate-x-0 lg:flex-shrink-0 overflow-y-auto overflow-x-hidden">
                @include('layouts.employee.sidebar')
            </div>

            <!-- Mobile overlay -->
            <div x-show="sidebarOpen && window.innerWidth < 1024" 
                 x-transition:enter="transition-opacity ease-in-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-in-out duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="sidebarOpen = false"
                 class="fixed inset-0 z-40 bg-black/50 lg:hidden">
            </div>
            
            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden w-full min-w-0">
                @include('layouts.employee.header')
                
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-4 lg:p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>

        @livewireScripts
        <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    </body>
</html>