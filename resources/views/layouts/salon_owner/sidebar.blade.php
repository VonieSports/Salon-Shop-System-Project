@php
    $tenant = Auth::user()->tenant;
@endphp

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
        <!-- Logo -->
        <div class="flex items-center gap-3 px-4 py-4 border-b border-gray-100 shrink-0">
            <div class="w-9 h-9 rounded-lg bg-[#1E7A4A] flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c-1.5 2-4 3-4 6a4 4 0 008 0c0-3-2.5-4-4-6z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 13v8M9 18h6"/>
                </svg>
            </div>
            <span class="font-bold text-lg text-gray-800 tracking-tight">BeautyNova</span>
        </div>

        <!-- Business Info -->
        <div class="px-4 py-4 border-b border-gray-100 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0 overflow-hidden">
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
                    <p class="text-xs text-gray-500 truncate">{{ $tenant->email ?? 'No business email' }}</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto px-3 py-3 space-y-1">
            
            <!-- Dashboard -->
            <a href="{{ route('owner.dashboard') }}" wire:navigate 
               class="sidebar-item flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 ease-in-out text-gray-700 hover:bg-gray-50 hover:text-gray-900"
               @click="if(window.innerWidth < 1024) sidebarOpen = false">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <!-- MANAGEMENT -->
            <div x-data="{ open: localStorage.getItem('managementOpen') === 'true' }" 
                 x-init="$watch('open', val => localStorage.setItem('managementOpen', val))"
                 class="pt-2 border-t border-gray-100">
                <div @click="open = !open" 
                     class="flex items-center justify-between px-4 py-2 rounded-lg text-[10px] font-bold uppercase tracking-wider cursor-pointer select-none transition-colors duration-200 text-gray-400 hover:text-gray-600">
                    <span>Management</span>
                    <svg class="w-4 h-4 transition-transform duration-300 ease-in-out" 
                         :class="open ? 'rotate-180' : ''" 
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>

                <div x-show="open" x-collapse.duration.300ms class="mt-1 ml-2 pl-3 border-l-2 border-gray-200 flex flex-col gap-0.5">
                    <a href="#" class="sidebar-item flex items-center gap-3 px-4 py-2 pl-8 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Employees
                    </a>
                    
                    <a href="{{ route('owner.create_product') }}" wire:navigate 
                       class="sidebar-item flex items-center gap-3 px-4 py-2 pl-8 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out text-gray-600 hover:bg-gray-50 hover:text-gray-900"
                       @click="if(window.innerWidth < 1024) sidebarOpen = false">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Create Products
                    </a>
                    
                    <a href="{{ route('owner.create_service') }}" wire:navigate 
                       class="sidebar-item flex items-center gap-3 px-4 py-2 pl-8 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out text-gray-600 hover:bg-gray-50 hover:text-gray-900"
                       @click="if(window.innerWidth < 1024) sidebarOpen = false">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Create Services
                    </a>

                    <a href="{{ route('owner.product_management') }}" wire:navigate 
                       class="sidebar-item flex items-center gap-3 px-4 py-2 pl-8 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out text-gray-600 hover:bg-gray-50 hover:text-gray-900"
                       @click="if(window.innerWidth < 1024) sidebarOpen = false">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Products
                    </a>
                    
                    <a href="{{ route('owner.service_management') }}" wire:navigate 
                       class="sidebar-item flex items-center gap-3 px-4 py-2 pl-8 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out text-gray-600 hover:bg-gray-50 hover:text-gray-900"
                       @click="if(window.innerWidth < 1024) sidebarOpen = false">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Services
                    </a>

                    <a href="{{ route('owner.category_management') }}" wire:navigate 
                       class="sidebar-item flex items-center gap-3 px-4 py-2 pl-8 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out text-gray-600 hover:bg-gray-50 hover:text-gray-900"
                       @click="if(window.innerWidth < 1024) sidebarOpen = false">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        Categories
                    </a>
                    
                    <a href="#" class="sidebar-item flex items-center gap-3 px-4 py-2 pl-8 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Accounts
                    </a>
                </div>
            </div>

            <!-- OPERATIONS -->
            <div x-data="{ open: localStorage.getItem('operationsOpen') === 'true' }" 
                 x-init="$watch('open', val => localStorage.setItem('operationsOpen', val))"
                 class="pt-2 border-t border-gray-100">
                <div @click="open = !open" 
                     class="flex items-center justify-between px-4 py-2 rounded-lg text-[10px] font-bold uppercase tracking-wider cursor-pointer select-none transition-colors duration-200 text-gray-400 hover:text-gray-600">
                    <span>Operations</span>
                    <svg class="w-4 h-4 transition-transform duration-300 ease-in-out" 
                         :class="open ? 'rotate-180' : ''" 
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>

                <div x-show="open" x-collapse.duration.300ms class="mt-1 ml-2 pl-3 border-l-2 border-gray-200 flex flex-col gap-0.5">
                    <a href="#" class="sidebar-item flex items-center gap-3 px-4 py-2 pl-8 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Orders
                    </a>
                    
                    <a href="#" class="sidebar-item flex items-center gap-3 px-4 py-2 pl-8 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Bookings
                    </a>
                    
                    <a href="#" class="sidebar-item flex items-center gap-3 px-4 py-2 pl-8 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Reservations
                    </a>
                    
                    <a href="#" class="sidebar-item flex items-center gap-3 px-4 py-2 pl-8 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                        </svg>
                        Customer Feedback
                    </a>
                    
                    <a href="#" class="sidebar-item flex items-center gap-3 px-4 py-2 pl-8 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        Walk-in Customers
                    </a>
                </div>
            </div>

            <!-- BUSINESS -->
            <div x-data="{ open: localStorage.getItem('businessOpen') === 'true' }" 
                 x-init="$watch('open', val => localStorage.setItem('businessOpen', val))"
                 class="pt-2 border-t border-gray-100">
                <div @click="open = !open" 
                     class="flex items-center justify-between px-4 py-2 rounded-lg text-[10px] font-bold uppercase tracking-wider cursor-pointer select-none transition-colors duration-200 text-gray-400 hover:text-gray-600">
                    <span>Business</span>
                    <svg class="w-4 h-4 transition-transform duration-300 ease-in-out" 
                         :class="open ? 'rotate-180' : ''" 
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>

                <div x-show="open" x-collapse.duration.300ms class="mt-1 ml-2 pl-3 border-l-2 border-gray-200 flex flex-col gap-0.5">
                    <a href="#" class="sidebar-item flex items-center gap-3 px-4 py-2 pl-8 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        Performance Analytics
                    </a>
                    
                    <a href="#" class="sidebar-item flex items-center gap-3 px-4 py-2 pl-8 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Inventory
                    </a>
                    
                    <a href="#" class="sidebar-item flex items-center gap-3 px-4 py-2 pl-8 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Your Shop
                    </a>
                </div>
            </div>
        </nav>

        <!-- Settings & Logout -->
        <div class="border-t border-gray-100 px-3 py-3 space-y-1 shrink-0">
            <a href="#" class="sidebar-item flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 ease-in-out text-gray-700 hover:bg-gray-50 hover:text-gray-900"
               @click="if(window.innerWidth < 1024) sidebarOpen = false">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Settings
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-semibold text-red-600 hover:bg-red-50 transition-all duration-200 ease-in-out"
                        @click="if(window.innerWidth < 1024) sidebarOpen = false">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
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
            <span class="font-bold text-lg text-gray-800 tracking-tight">BeautyNova</span>
        </div>

        <!-- Business Info -->
        <div class="px-6 py-5 border-b border-gray-100 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0 overflow-hidden">
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
                    <p class="text-xs text-gray-500 truncate">{{ $tenant->email ?? 'No business email' }}</p>
                </div>
            </div>
        </div>

        <!-- Navigation (Desktop) -->
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
            
            <!-- Dashboard -->
            <a href="{{ route('owner.dashboard') }}" wire:navigate 
               class="sidebar-item flex items-center gap-3.5 px-4 py-3 rounded-lg text-sm font-semibold transition-all duration-200 ease-in-out text-gray-700 hover:bg-gray-50 hover:text-gray-900">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <!-- MANAGEMENT (Desktop) -->
            <div x-data="{ open: localStorage.getItem('managementOpen') === 'true' }" 
                 x-init="$watch('open', val => localStorage.setItem('managementOpen', val))"
                 class="pt-2 border-t border-gray-100">
                <div @click="open = !open" 
                     class="flex items-center justify-between px-4 py-2 rounded-lg text-xs font-semibold uppercase tracking-wider cursor-pointer select-none transition-colors duration-200 text-gray-400 hover:text-gray-600">
                    <span>Management</span>
                    <svg class="w-4 h-4 transition-transform duration-300 ease-in-out" 
                         :class="open ? 'rotate-180' : ''" 
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>

                <div x-show="open" x-collapse.duration.300ms class="mt-1 ml-2 pl-3 border-l-2 border-gray-200 flex flex-col gap-0.5">
                    <a href="#" class="sidebar-item flex items-center gap-3.5 px-4 py-2.5 pl-9 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Employees
                    </a>
                    
                    <a href="{{ route('owner.create_product') }}" wire:navigate 
                       class="sidebar-item flex items-center gap-3.5 px-4 py-2.5 pl-9 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Create Products
                    </a>
                    
                    <a href="{{ route('owner.create_service') }}" wire:navigate 
                       class="sidebar-item flex items-center gap-3.5 px-4 py-2.5 pl-9 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Create Services
                    </a>

                    <a href="{{ route('owner.product_management') }}" wire:navigate 
                       class="sidebar-item flex items-center gap-3.5 px-4 py-2.5 pl-9 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Products
                    </a>
                    
                    <a href="{{ route('owner.service_management') }}" wire:navigate 
                       class="sidebar-item flex items-center gap-3.5 px-4 py-2.5 pl-9 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Services
                    </a>
                    
                    <a href="{{ route('owner.category_management') }}" wire:navigate 
                       class="sidebar-item flex items-center gap-3.5 px-4 py-2.5 pl-9 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        Categories
                    </a>

                    <a href="#" class="sidebar-item flex items-center gap-3.5 px-4 py-2.5 pl-9 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Accounts
                    </a>
                </div>
            </div>

            <!-- OPERATIONS (Desktop) -->
            <div x-data="{ open: localStorage.getItem('operationsOpen') === 'true' }" 
                 x-init="$watch('open', val => localStorage.setItem('operationsOpen', val))"
                 class="pt-2 border-t border-gray-100">
                <div @click="open = !open" 
                     class="flex items-center justify-between px-4 py-2 rounded-lg text-xs font-semibold uppercase tracking-wider cursor-pointer select-none transition-colors duration-200 text-gray-400 hover:text-gray-600">
                    <span>Operations</span>
                    <svg class="w-4 h-4 transition-transform duration-300 ease-in-out" 
                         :class="open ? 'rotate-180' : ''" 
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>

                <div x-show="open" x-collapse.duration.300ms class="mt-1 ml-2 pl-3 border-l-2 border-gray-200 flex flex-col gap-0.5">
                    <a href="#" class="sidebar-item flex items-center gap-3.5 px-4 py-2.5 pl-9 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Orders
                    </a>
                    
                    <a href="#" class="sidebar-item flex items-center gap-3.5 px-4 py-2.5 pl-9 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Bookings
                    </a>
                    
                    <a href="#" class="sidebar-item flex items-center gap-3.5 px-4 py-2.5 pl-9 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Reservations
                    </a>
                    
                    <a href="#" class="sidebar-item flex items-center gap-3.5 px-4 py-2.5 pl-9 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                        </svg>
                        Customer Feedback
                    </a>
                    
                    <a href="#" class="sidebar-item flex items-center gap-3.5 px-4 py-2.5 pl-9 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        Walk-in Customers
                    </a>
                </div>
            </div>

            <!-- BUSINESS (Desktop) -->
            <div x-data="{ open: localStorage.getItem('businessOpen') === 'true' }" 
                 x-init="$watch('open', val => localStorage.setItem('businessOpen', val))"
                 class="pt-2 border-t border-gray-100">
                <div @click="open = !open" 
                     class="flex items-center justify-between px-4 py-2 rounded-lg text-xs font-semibold uppercase tracking-wider cursor-pointer select-none transition-colors duration-200 text-gray-400 hover:text-gray-600">
                    <span>Business</span>
                    <svg class="w-4 h-4 transition-transform duration-300 ease-in-out" 
                         :class="open ? 'rotate-180' : ''" 
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>

                <div x-show="open" x-collapse.duration.300ms class="mt-1 ml-2 pl-3 border-l-2 border-gray-200 flex flex-col gap-0.5">
                    <a href="#" class="sidebar-item flex items-center gap-3.5 px-4 py-2.5 pl-9 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        Performance Analytics
                    </a>
                    
                    <a href="#" class="sidebar-item flex items-center gap-3.5 px-4 py-2.5 pl-9 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Inventory
                    </a>
                    
                    <a href="#" class="sidebar-item flex items-center gap-3.5 px-4 py-2.5 pl-9 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Your Shop
                    </a>
                </div>
            </div>
        </nav>

        <!-- Settings & Logout (Desktop) -->
        <div class="border-t border-gray-100 px-4 py-4 space-y-1 shrink-0">
            <a href="#" class="sidebar-item flex items-center gap-3.5 px-4 py-3 rounded-lg text-sm font-semibold transition-all duration-200 ease-in-out text-gray-700 hover:bg-gray-50 hover:text-gray-900">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Settings
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3.5 px-4 py-3 rounded-lg text-sm font-semibold text-red-600 hover:bg-red-50 transition-all duration-200 ease-in-out">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Logout
                </button>
            </form>
            </div>
    </div>
</aside>