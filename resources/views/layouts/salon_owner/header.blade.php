<header class="bg-white border-b border-gray-200 h-[60px] sm:h-[68px] flex items-center px-3 sm:px-5 md:px-6 lg:px-6 gap-2 sm:gap-3 md:gap-4 lg:gap-4 shrink-0 z-20 sticky top-0 shadow-sm">
    <button @click="sidebarOpen = !sidebarOpen"
        class="lg:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition shrink-0">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    <div class="flex items-center gap-2 shrink-0 lg:hidden">
        <div class="w-8 h-8 rounded-lg bg-emerald-600 flex items-center justify-center shrink-0">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c-1.5 2-4 3-4 6a4 4 0 008 0c0-3-2.5-4-4-6z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 13v8M9 18h6"/>
            </svg>
        </div>
        <span class="font-bold text-base text-gray-800 tracking-tight hidden sm:block">BeautyNova</span>
        <span class="font-bold text-sm text-gray-800 tracking-tight sm:hidden">BN</span>
    </div>

    <!-- Mobile & Tablet Search Toggle -->
    <div x-data="{ searchOpen: false }" class="flex-1 flex items-center lg:hidden">
        <button @click="searchOpen = !searchOpen" 
                class="p-2 rounded-lg text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 transition shrink-0 ml-auto">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </button>

        <!-- Mobile Search Overlay -->
        <div x-show="searchOpen"
             x-transition:enter="transition-all duration-200 ease-in-out"
             x-transition:enter-start="opacity-0 translate-y-[-10px]"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition-all duration-150 ease-in-out"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-[-10px]"
             class="fixed inset-0 bg-white z-[100] flex flex-col"
             style="display: none;">
            
            <!-- Search Header -->
            <div class="flex items-center gap-3 px-4 py-3 border-b border-gray-100">
                <button @click="searchOpen = false" 
                        class="p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
                
                <div class="relative flex-1">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" 
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" 
                           placeholder="Search"
                           class="w-full pl-9 pr-3 py-2 text-sm rounded-lg bg-gray-50 border border-gray-200 
                                  focus:outline-none focus:bg-white focus:border-emerald-400
                                  transition placeholder-gray-400"
                           autofocus>
                </div>
                
                <button class="px-4 py-2 bg-emerald-600 text-white text-sm font-semibold rounded-lg hover:bg-emerald-700 transition whitespace-nowrap">
                    Search
                </button>
            </div>
            
            <!-- Recent Searches -->
            <div class="px-4 py-4 flex-1">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-sm font-semibold text-gray-700">Recent Searches</p>
                    <button class="text-xs text-emerald-600 hover:text-emerald-700 font-medium">Clear All</button>
                </div>
                <div class="flex flex-wrap gap-2">
                    <span class="bg-gray-100 px-3 py-1.5 rounded-full text-sm text-gray-700 hover:bg-gray-200 cursor-pointer transition">Hair salon</span>
                    <span class="bg-gray-100 px-3 py-1.5 rounded-full text-sm text-gray-700 hover:bg-gray-200 cursor-pointer transition">Nail art</span>
                    <span class="bg-gray-100 px-3 py-1.5 rounded-full text-sm text-gray-700 hover:bg-gray-200 cursor-pointer transition">Skincare</span>
                    <span class="bg-gray-100 px-3 py-1.5 rounded-full text-sm text-gray-700 hover:bg-gray-200 cursor-pointer transition">Massage</span>
                    <span class="bg-gray-100 px-3 py-1.5 rounded-full text-sm text-gray-700 hover:bg-gray-200 cursor-pointer transition">Facial</span>
                </div>
                
                <!-- Popular Searches -->
                <div class="mt-6">
                    <p class="text-sm font-semibold text-gray-700 mb-3">Popular Searches</p>
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-full text-sm hover:bg-emerald-100 cursor-pointer transition">Haircut</span>
                        <span class="bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-full text-sm hover:bg-emerald-100 cursor-pointer transition">Manicure</span>
                        <span class="bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-full text-sm hover:bg-emerald-100 cursor-pointer transition">Pedicure</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="hidden lg:flex flex-1 items-center max-w-sm ml-auto">
        <div class="relative w-full">
            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" 
                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" 
                   placeholder="Search"
                   class="w-full pl-9 pr-3 py-2 text-sm border border-gray-200 rounded-lg bg-gray-50 
                          focus:outline-none focus:bg-white focus:border-emerald-400
                          transition placeholder-gray-400">
        </div>
    </div>

    <div class="flex items-center gap-1.5 sm:gap-2 md:gap-2.5 lg:gap-2.5 ml-auto shrink-0">>
        <button class="hidden lg:flex p-2 rounded-lg text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
            </svg>
        </button>

        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                class="p-2 rounded-lg text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 transition relative">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">8</span>
            </button>

            <div x-show="open" @click.away="open = false"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-lg border border-gray-200 z-50 py-2">
                <div class="px-4 py-2.5 border-b border-gray-100 flex items-center justify-between">
                    <p class="text-sm font-semibold text-gray-700">Notifications</p>
                    <span class="text-xs text-emerald-600 hover:text-emerald-700 cursor-pointer font-medium">Mark all read</span>
                </div>
                <div class="px-4 py-3 border-b border-gray-100 hover:bg-gray-50 cursor-pointer transition">
                    <p class="text-sm font-medium text-gray-800">New appointment booked</p>
                    <p class="text-xs text-gray-500">2 min ago</p>
                </div>
                <div class="px-4 py-3 border-b border-gray-100 hover:bg-gray-50 cursor-pointer transition">
                    <p class="text-sm font-medium text-gray-800">Payment received</p>
                    <p class="text-xs text-gray-500">1 hour ago</p>
                </div>
                <div class="px-4 py-2.5 border-t border-gray-100 text-center">
                    <a href="#" class="text-xs text-emerald-600 hover:text-emerald-700 font-medium">View all</a>
                </div>
            </div>
        </div>

        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                class="flex items-center gap-1.5 px-1.5 py-1 rounded-lg hover:bg-gray-100 transition">
                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center shrink-0 border-2 border-emerald-200">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full rounded-full object-cover">
                    @else
                        <span class="text-sm font-bold text-emerald-700">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                    @endif
                </div>
                <span class="hidden sm:block text-sm font-medium text-gray-700 truncate max-w-[80px]">{{ Auth::user()->name }}</span>
                <svg class="w-3 h-3 text-gray-500 hidden sm:block" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="open" @click.away="open = false"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-lg border border-gray-200 z-50 py-1.5">
                <a href="{{ route('owner.profile') }}" wire:navigate 
                   class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition font-medium">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    My Profile
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition font-medium">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Settings
                </a>
                <div class="border-t border-gray-100 my-1"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>