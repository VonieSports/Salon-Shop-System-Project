<header class="bg-white border-b border-gray-100 h-14 sm:h-16 flex items-center px-3 sm:px-4 md:px-6 gap-2 sm:gap-3 md:gap-4 lg:gap-6 shrink-0 z-20 sticky top-0">
    <!-- Hamburger - Mobile Only -->
    <button @click="sidebarOpen = !sidebarOpen"
        class="lg:hidden p-1.5 sm:p-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition shrink-0">
        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    <!-- Search -->
    <div class="flex-1 flex items-center gap-1 sm:gap-2 min-w-0 max-w-full sm:max-w-md md:max-w-lg lg:max-w-xl">
        <div class="relative flex-1 min-w-0">
            <svg class="absolute left-2 sm:left-3 md:left-4 top-1/2 -translate-y-1/2 w-3.5 h-3.5 sm:w-4 sm:h-4 md:w-5 md:h-5 text-gray-400" 
                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" placeholder="Search..."
                class="w-full pl-7 sm:pl-9 md:pl-11 pr-2 sm:pr-3 py-1.5 sm:py-2 md:py-2.5 text-xs sm:text-sm md:text-base 
                       border border-gray-200 rounded-full bg-gray-50 
                       focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white 
                       transition placeholder-gray-400">
        </div>

        {{-- Filter button --}}
        <button class="p-1.5 sm:p-2 md:p-2.5 rounded-lg border border-gray-200 bg-gray-50 
                       text-gray-600 hover:text-emerald-600 hover:border-emerald-300 hover:bg-emerald-50 
                       transition shrink-0">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-[22px] md:h-[22px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
            </svg>
        </button>
    </div>

    <!-- Right Side Icons -->
    <div class="flex items-center gap-0.5 sm:gap-1 md:gap-1.5 ml-auto shrink-0">

   
        {{-- Notifications --}}
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                class="p-1.5 sm:p-2 md:p-2.5 rounded-lg text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 transition relative">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-[22px] md:h-[22px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="absolute -top-0.5 -right-0.5 w-3.5 h-3.5 sm:w-4 sm:h-4 bg-red-500 text-white text-[8px] sm:text-[10px] font-bold rounded-full flex items-center justify-center">8</span>
            </button>

            <!-- Notification Dropdown -->
            <div x-show="open" @click.away="open = false"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="absolute right-0 mt-2 w-72 sm:w-80 bg-white rounded-xl shadow-lg border border-gray-100 z-50 py-2">
                <div class="px-4 sm:px-5 py-2 sm:py-2.5 border-b border-gray-100 flex items-center justify-between">
                    <p class="text-xs sm:text-sm font-semibold text-gray-700">Notifications</p>
                    <span class="text-[10px] sm:text-xs text-emerald-600 hover:text-emerald-700 cursor-pointer font-medium">Mark all read</span>
                </div>
             
                <div class="px-4 sm:px-5 py-2 sm:py-2.5 border-t border-gray-100 text-center">
                    <a href="#" class="text-xs sm:text-sm text-emerald-600 hover:text-emerald-700 font-medium">View all notifications</a>
                </div>
            </div>
        </div>

        <button class="p-1.5 sm:p-2 md:p-2.5 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-[22px] md:h-[22px]" fill="currentColor" viewBox="0 0 24 24">
                <circle cx="12" cy="5" r="2"/>
                <circle cx="12" cy="12" r="2"/>
                <circle cx="12" cy="19" r="2"/>
            </svg>
        </button>

        <button class="p-1.5 sm:p-2 md:p-2.5 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition hidden sm:inline-flex">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-[22px] md:h-[22px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
            </svg>
        </button>

        {{-- Profile Dropdown --}}
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                class="flex items-center gap-1 sm:gap-2 md:gap-3 px-1.5 sm:px-2 md:px-3 py-1 sm:py-1.5 md:py-2 rounded-lg hover:bg-gray-100 transition">
                <div class="w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full rounded-full object-cover">
                    @else
                        <span class="text-xs sm:text-sm font-bold text-emerald-700">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                    @endif
                </div>
                <div class="hidden sm:block text-left min-w-0">
                    <p class="text-xs sm:text-sm font-semibold text-gray-800 leading-tight truncate max-w-[80px] md:max-w-[120px]">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] sm:text-xs text-emerald-600 font-semibold">● Owner</p>
                </div>
                <svg class="w-3 h-3 sm:w-4 sm:h-4 text-gray-500 hidden sm:block" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="open" @click.away="open = false"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="absolute right-0 mt-2 w-48 sm:w-52 bg-white rounded-xl shadow-lg border border-gray-100 z-50 py-2">
                <a href="{{ route('owner.profile') }}" wire:navigate class="flex items-center gap-2 sm:gap-3 px-4 sm:px-5 py-2.5 sm:py-3 text-xs sm:text-sm text-gray-700 hover:bg-gray-50 transition font-medium">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    My Profile
                </a>
                <a href="#" class="flex items-center gap-2 sm:gap-3 px-4 sm:px-5 py-2.5 sm:py-3 text-xs sm:text-sm text-gray-700 hover:bg-gray-50 transition font-medium">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Settings
                </a>
                <div class="border-t border-gray-100 my-1"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 sm:gap-3 px-4 sm:px-5 py-2.5 sm:py-3 text-xs sm:text-sm text-red-600 hover:bg-red-50 transition font-medium">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>

    </div>
</header>