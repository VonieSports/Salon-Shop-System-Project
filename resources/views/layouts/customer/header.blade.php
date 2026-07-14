
<div class="flex items-center gap-2 sm:gap-3 w-full h-full">
    {{-- Hamburger --}}
    <button @click="sidebarOpen = !sidebarOpen" class="p-2 -ml-1 rounded-lg hover:bg-gray-100 transition-colors shrink-0">
        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    {{-- Logo (mobile only — desktop logo lives in the sidebar) --}}
    <a href="" class="flex items-center gap-2 shrink-0 lg:hidden">
        <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center shrink-0">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
        </span>
        <span class="font-extrabold text-lg text-gray-900">Nova<span class="text-indigo-600">Shop</span></span>
    </a>

    {{-- Search bar (desktop) --}}
    <div class="hidden lg:flex flex-1 max-w-2xl">
        <div class="relative w-full">
            <input type="text" placeholder="Search for products, brands and more..."
                   class="w-full pl-5 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:bg-white transition text-sm">
            <button class="absolute right-1.5 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-indigo-600 hover:bg-indigo-700 flex items-center justify-center transition-colors">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Search toggle (mobile) --}}
    <button @click="searchOpen = !searchOpen" class="lg:hidden ml-auto p-2 rounded-lg hover:bg-gray-100 transition-colors">
        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
    </button>

    {{-- Right side icons (shared markup, responsive via Tailwind) --}}
    <div class="flex items-center gap-0.5 lg:gap-1 shrink-0">
        <a href="#" class="flex items-center gap-2 px-2.5 lg:px-3 py-2.5 rounded-lg hover:bg-gray-100 transition-colors">
            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            <span class="hidden lg:inline text-sm font-semibold text-gray-700">Wishlist</span>
        </a>

        <button class="relative p-2.5 rounded-lg hover:bg-gray-100 transition-colors">
            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <span class="absolute top-1 right-1 w-4 h-4 bg-red-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center">3</span>
        </button>

        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center gap-2 pl-1 pr-1 lg:pr-2 py-1 rounded-full hover:bg-gray-100 transition-colors">
                <div class="w-9 h-9 rounded-full bg-gray-200 flex items-center justify-center text-gray-700 text-sm font-bold shrink-0">
                    {{ Auth::check() ? strtoupper(substr(Auth::user()->name, 0, 1)) : 'G' }}
                </div>
                <span class="hidden lg:block text-sm font-semibold text-gray-800 max-w-[110px] truncate">
                    {{ Auth::check() ? Auth::user()->name : 'Guest' }}
                </span>
                <svg class="hidden lg:block w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="open" @click.away="open = false"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 z-50 py-2">
                <div class="px-4 py-3 border-b border-gray-100">
                    <p class="text-sm font-semibold text-gray-800">{{ Auth::check() ? Auth::user()->name : 'Guest' }}</p>
                    <p class="text-xs text-gray-500">{{ Auth::check() ? Auth::user()->email : 'Sign in to continue' }}</p>
                </div>
                @auth
                    <a href="#" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">My Profile</a>
                    <a href="#" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">My Orders</a>
                    <a href="#" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">Wishlist</a>
                    <div class="border-t border-gray-100 my-1"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition">Sign Out</button>
                    </form>
                @else
                    <a href="" class="block px-4 py-2.5 text-sm text-indigo-600 font-medium">Sign In</a>
                    <a href="" class="block px-4 py-2.5 text-sm text-gray-600">Create Account</a>
                @endauth
            </div>
        </div>
    </div>
</div>

{{-- Mobile search — floats over content, doesn't push layout --}}
<div x-show="searchOpen" x-transition
     class="lg:hidden absolute top-full left-0 right-0 bg-white border-b border-gray-100 px-4 py-3 shadow-sm">
    <div class="relative">
        <input type="text" placeholder="Search for products..."
               class="w-full pl-5 pr-12 py-2.5 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:bg-white transition text-sm">
        <button class="absolute right-1.5 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </button>
    </div>
</div>