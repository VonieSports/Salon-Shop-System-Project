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
        sidebarOpen: false,
        init() {
            // Only open on desktop by default
            if (window.innerWidth >= 1024) {
                this.sidebarOpen = true;
            }
            
            // Handle resize - close on mobile, open on desktop
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) {
                    this.sidebarOpen = true;
                } else {
                    this.sidebarOpen = false;
                }
            });
            
            // Close sidebar on navigation for mobile
            window.addEventListener('livewire:navigating', () => {
                if (window.innerWidth < 1024) {
                    this.sidebarOpen = false;
                }
            });
        },
        toggleSidebar() {
            this.sidebarOpen = !this.sidebarOpen;
        },
        closeSidebar() {
            this.sidebarOpen = false;
        }
    }" 
    x-init="init()" 
    class="bg-gray-100 overflow-x-hidden">
        <div class="flex h-screen overflow-hidden">
            <!-- Sidebar -->
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition-all duration-300 ease-in-out"
                 x-transition:enter-start="-translate-x-full opacity-0"
                 x-transition:enter-end="translate-x-0 opacity-100"
                 x-transition:leave="transition-all duration-300 ease-in-out"
                 x-transition:leave-start="translate-x-0 opacity-100"
                 x-transition:leave-end="-translate-x-full opacity-0"
                 class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 lg:relative lg:translate-x-0 lg:flex-shrink-0 overflow-y-auto overflow-x-hidden shadow-2xl lg:shadow-none">
                @include('layouts.employee.sidebar')
            </div>

            <!-- Mobile overlay -->
            <div x-show="sidebarOpen && window.innerWidth < 1024" 
                 x-transition:enter="transition-opacity duration-300 ease-in-out"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity duration-300 ease-in-out"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="closeSidebar()"
                 class="fixed inset-0 z-40 bg-black/50 lg:hidden">
            </div>
            
            <div class="flex-1 flex flex-col overflow-hidden w-full min-w-0">
                @include('layouts.employee.header')
                
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-0 lg:p-4">
                    {{ $slot }}
                </main>
            </div>
        </div>

        @livewireScripts
        <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    </body>
</html>