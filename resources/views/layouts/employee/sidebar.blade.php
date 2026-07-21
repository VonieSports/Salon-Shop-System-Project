{{-- resources/views/layouts/employee/sidebar.blade.php --}}

@php
    $tenant = Auth::user()->tenant;
@endphp

<!-- Mobile Sidebar -->
<aside class="fixed top-0 left-0 bottom-0 w-[280px] sm:w-[320px] bg-white z-50 lg:hidden shadow-xl overflow-y-auto"
       x-show="sidebarOpen"
       x-transition:enter="transition-transform duration-300 ease-out"
       x-transition:enter-start="-translate-x-full"
       x-transition:enter-end="translate-x-0"
       x-transition:leave="transition-transform duration-300 ease-in"
       x-transition:leave-start="translate-x-0"
       x-transition:leave-end="-translate-x-full"
       x-cloak>
    <div class="flex flex-col h-full">
        <!-- Close button -->
        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-[#1E7A4A] flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c-1.5 2-4 3-4 6a4 4 0 008 0c0-3-2.5-4-4-6z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 13v8M9 18h6"/>
                    </svg>
                </div>
                <span class="font-bold text-lg text-gray-800">{{ config('app.name') }}</span>
            </div>
            <button @click="sidebarOpen = false" class="p-2 text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Business Info -->
        <div class="px-4 py-3 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-emerald-100 flex items-center justify-center overflow-hidden">
                    @if($tenant && $tenant->logo)
                        <img src="{{ Storage::url($tenant->logo) }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    @endif
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ $tenant->name ?? 'No Business' }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ $tenant->email ?? '' }}</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto px-3 py-3 space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('employee.dashboard') }}" wire:navigate 
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 text-gray-700 hover:bg-gray-50 hover:text-gray-900 {{ request()->routeIs('employee.dashboard') ? 'bg-gray-50 text-gray-900' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <!-- MANAGEMENT Section -->
            @canany(['can_view', 'can_view_any'])
            <div x-data="{ open: localStorage.getItem('employeeManagementOpen') === 'true' }" 
                 x-init="$watch('open', val => localStorage.setItem('employeeManagementOpen', val))"
                 class="pt-2 border-t border-gray-100">
                <div @click="open = !open" 
                     class="flex items-center justify-between px-3 py-2 rounded-lg text-xs font-semibold uppercase tracking-wider cursor-pointer select-none text-gray-400 hover:text-gray-600">
                    <span>Management</span>
                    <svg class="w-4 h-4 transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>

                <div x-show="open" x-collapse.duration.300ms class="mt-1 ml-2 pl-3 border-l-2 border-gray-200 space-y-0.5">
                    @can('can_view')
                    <a href="#" class="flex items-center gap-3 px-3 py-2 pl-8 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Products
                    </a>
                    @endcan

                    @can('can_view')
                    <a href="#" class="flex items-center gap-3 px-3 py-2 pl-8 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Services
                    </a>
                    @endcan

                    @can('can_view_any')
                    <a href="#" class="flex items-center gap-3 px-3 py-2 pl-8 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Orders
                    </a>
                    @endcan

                    @can('can_create')
                    <a href="#" class="flex items-center gap-3 px-3 py-2 pl-8 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Create New
                    </a>
                    @endcan
                </div>
            </div>
            @endcanany

            <!-- Settings -->
            @can('can_update')
            <div class="pt-2 border-t border-gray-100">
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 text-gray-700 hover:bg-gray-50 hover:text-gray-900">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Settings
                </a>
            </div>
            @endcan
        </nav>

        <!-- Logout -->
        <div class="border-t border-gray-100 px-3 py-3 shrink-0">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition-all duration-200">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- Desktop Sidebar -->
<aside class="hidden lg:flex lg:w-[270px] lg:shrink-0 lg:h-full lg:overflow-y-auto lg:border-r lg:border-gray-100 lg:bg-white">
    <div class="flex flex-col h-full w-full overflow-y-auto">
        <!-- Logo -->
        <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-100 shrink-0">
            <div class="w-9 h-9 rounded-lg bg-[#1E7A4A] flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c-1.5 2-4 3-4 6a4 4 0 008 0c0-3-2.5-4-4-6z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 13v8M9 18h6"/>
                </svg>
            </div>
            <span class="font-bold text-lg text-gray-800 tracking-tight">{{ config('app.name') }}</span>
        </div>

        <!-- Business Info -->
        <div class="px-6 py-4 border-b border-gray-100 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center overflow-hidden">
                    @if($tenant && $tenant->logo)
                        <img src="{{ Storage::url($tenant->logo) }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    @endif
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ $tenant->name ?? 'No Business' }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ $tenant->email ?? '' }}</p>
                </div>
            </div>
        </div>

        <!-- Navigation (Desktop - same as mobile but without close button) -->
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('employee.dashboard') }}" wire:navigate 
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 text-gray-700 hover:bg-gray-50 hover:text-gray-900 {{ request()->routeIs('employee.dashboard') ? 'bg-gray-50 text-gray-900' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <!-- MANAGEMENT Section (Desktop) -->
            @canany(['can_view', 'can_view_any'])
            <div x-data="{ open: localStorage.getItem('employeeManagementOpen') === 'true' }" 
                 x-init="$watch('open', val => localStorage.setItem('employeeManagementOpen', val))"
                 class="pt-2 border-t border-gray-100">
                <div @click="open = !open" 
                     class="flex items-center justify-between px-3 py-2 rounded-lg text-xs font-semibold uppercase tracking-wider cursor-pointer select-none text-gray-400 hover:text-gray-600">
                    <span>Management</span>
                    <svg class="w-4 h-4 transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>

                <div x-show="open" x-collapse.duration.300ms class="mt-1 ml-2 pl-3 border-l-2 border-gray-200 space-y-0.5">
                    @can('can_view')
                    <a href="#" class="flex items-center gap-3 px-3 py-2 pl-8 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Products
                    </a>
                    @endcan

                    @can('can_view')
                    <a href="#" class="flex items-center gap-3 px-3 py-2 pl-8 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Services
                    </a>
                    @endcan

                    @can('can_view_any')
                    <a href="#" class="flex items-center gap-3 px-3 py-2 pl-8 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Orders
                    </a>
                    @endcan

                    @can('can_create')
                    <a href="#" class="flex items-center gap-3 px-3 py-2 pl-8 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Create New
                    </a>
                    @endcan
                </div>
            </div>
            @endcanany

            <!-- Settings -->
            @can('can_update')
            <div class="pt-2 border-t border-gray-100">
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 text-gray-700 hover:bg-gray-50 hover:text-gray-900">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Settings
                </a>
            </div>
            @endcan
        </nav>

        <!-- Logout (Desktop) -->
        <div class="border-t border-gray-100 px-3 py-3 shrink-0">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition-all duration-200">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </div>
</aside>