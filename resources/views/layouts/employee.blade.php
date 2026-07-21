<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config('app.name') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body x-data="{ sidebarOpen: false }" class="bg-gray-100">
        <div class="flex h-screen">
            @include('layouts.employee.sidebar')
            
            <div class="flex-1 flex flex-col overflow-hidden">
                @include('layouts.employee.header')
                
                <main class="flex-1 lg:p-6 overflow-x-hidden overflow-y-auto bg-gray-100">
                    {{ $slot }}
                </main>
            </div>
        </div>

        @livewireScripts
    </body>
</html>
