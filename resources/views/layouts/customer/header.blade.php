<!-- Top Bar -->
<div class="hidden sm:block bg-[#1E7A4A] text-white text-[11px]">
    <div class="max-w-[1400px] mx-auto px-4">
        <div class="flex items-center justify-between h-8">
            <div class="flex items-center gap-4">
                <a href="#" class="hover:underline text-white/90 hover:text-white transition">Customer Service</a>
                <span class="text-white/30">|</span>
                <a href="{{ route('owner.login.page') }}" class="hover:text-white transition">Seller Centre</a>
                <span class="text-white/30">|</span>
                <a href="{{ route('owner.register.page') }}" class="hover:text-white transition">Become a Seller</a>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-white/70 text-[10px]">Follow us:</span>
                <div class="flex items-center gap-1">
                    <a href="#" class="text-white/60 hover:text-white transition p-0.5">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                    <a href="#" class="text-white/60 hover:text-white transition p-0.5">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069z"/></svg>
                    </a>
                    <a href="#" class="text-white/60 hover:text-white transition p-0.5">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Header (Shopee Size: h-[70px]) -->
<div class="bg-white border-b border-gray-200">
    <div class="max-w-[1400px] mx-auto px-4">
        <div class="flex items-center justify-between h-[70px]">
            <!-- Mobile Menu Toggle -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" 
                    class="lg:hidden text-gray-700 hover:text-emerald-600 p-1.5 rounded-lg hover:bg-gray-50 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <!-- Logo -->
            <a href="{{ route('index.page') }}" class="flex items-center gap-2 shrink-0">
                <svg class="w-6 h-6 sm:w-7 sm:h-7 text-emerald-800" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c-1.5 2-4 3-4 6a4 4 0 008 0c0-3-2.5-4-4-6z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 13v8M9 18h6"/>
                </svg>
                <span class="font-serif-display text-lg sm:text-xl lg:text-2xl font-bold text-emerald-800 tracking-tight whitespace-nowrap">Style Station</span>
            </a>

            <!-- Search Bar (Taller) -->
            <div class="hidden lg:flex flex-1 max-w-[520px] mx-8">
                <div class="relative w-full">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" placeholder="Search products..." 
                           class="w-full pl-11 pr-24 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent bg-gray-50 transition h-[46px]">
                    <button class="absolute right-1.5 top-1/2 -translate-y-1/2 bg-[#1E7A4A] hover:bg-[#16633c] text-white px-5 py-1.5 rounded-md text-sm font-medium transition h-[36px]">
                        Search
                    </button>
                </div>
            </div>

            <!-- Right Actions -->
            <div class="flex items-center gap-2 sm:gap-3">
                <button @click="searchOpen = !searchOpen" class="lg:hidden text-gray-700 hover:text-emerald-600 p-2 rounded-lg hover:bg-gray-50 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>

                <a href="#" class="hidden sm:flex text-gray-700 hover:text-emerald-600 p-2 rounded-lg hover:bg-gray-50 transition relative">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <span class="absolute -top-0.5 -right-0.5 bg-rose-500 text-white text-[9px] rounded-full w-4 h-4 flex items-center justify-center font-bold border border-white">2</span>
                </a>

                <a href="{{ route('customer.cart') }}" class="text-gray-700 hover:text-emerald-600 p-2 rounded-lg hover:bg-gray-50 transition relative">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="absolute -top-0.5 -right-0.5 bg-red-500 text-white text-[9px] rounded-full w-4 h-4 flex items-center justify-center font-bold border border-white">3</span>
                </a>

                <button class="hidden sm:flex text-gray-700 hover:text-emerald-600 p-2 rounded-lg hover:bg-gray-50 transition relative">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="absolute -top-0.5 -right-0.5 bg-emerald-600 text-white text-[9px] rounded-full w-4 h-4 flex items-center justify-center font-bold border border-white">5</span>
                </button>

                @guest
                    <a href="{{ route('login') }}" class="bg-[#1E7A4A] hover:bg-[#16633c] text-white text-sm font-medium px-4 py-1.5 rounded-lg transition whitespace-nowrap h-[36px] flex items-center">
                        Sign in
                    </a>
                @else
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-1.5 pl-1 pr-2 py-1 rounded-full hover:bg-gray-50 transition-colors">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 text-sm font-bold border-2 border-emerald-200">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden sm:block text-sm font-medium text-gray-700 max-w-[80px] truncate">{{ Auth::user()->name }}</span>
                            <svg class="hidden sm:block w-3 h-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-cloak
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 z-50 py-1">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="{{ route('customer.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">My Profile</a>
                            <a href="{{ route('customer.order_history') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">My Orders</a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">Sign Out</button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>

        <!-- Navigation -->
        <nav class="hidden lg:flex items-center gap-8 text-sm font-medium text-gray-600 py-2 border-t border-gray-100">
            <a href="{{ route('customer.dashboard') }}" class="relative py-1 hover:text-emerald-700 transition group font-semibold text-emerald-700">
                Home
                <span class="absolute -bottom-2 left-0 right-0 h-0.5 bg-emerald-600 rounded-full"></span>
            </a>
            <a href="#" class="relative py-1 hover:text-emerald-700 transition group">Shop <span class="absolute -bottom-2 left-0 right-0 h-0.5 bg-emerald-600 rounded-full transform scale-x-0 group-hover:scale-x-100 transition-transform duration-200"></span></a>
            <a href="#" class="relative py-1 hover:text-emerald-700 transition group">New Arrivals <span class="absolute -bottom-2 left-0 right-0 h-0.5 bg-emerald-600 rounded-full transform scale-x-0 group-hover:scale-x-100 transition-transform duration-200"></span></a>
            <a href="#" class="relative py-1 hover:text-emerald-700 transition group">Best Seller <span class="absolute -bottom-2 left-0 right-0 h-0.5 bg-emerald-600 rounded-full transform scale-x-0 group-hover:scale-x-100 transition-transform duration-200"></span></a>
            <div class="relative group">
                <a href="#" class="relative py-1 hover:text-emerald-700 transition flex items-center gap-1">Categories <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg><span class="absolute -bottom-2 left-0 right-0 h-0.5 bg-emerald-600 rounded-full transform scale-x-0 group-hover:scale-x-100 transition-transform duration-200"></span></a>
                <div class="absolute left-0 top-full pt-2 w-44 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-10">
                    <div class="bg-white rounded-lg shadow-lg border border-gray-100 py-2">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition">Hair Care</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition">Skincare</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition">Nail Art</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition">Makeup</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>

<!-- Mobile Search -->
<div x-show="searchOpen" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="lg:hidden bg-white border-b border-gray-200 px-4 py-3">
    <div class="relative max-w-full">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input type="text" placeholder="Search products..." class="w-full pl-9 pr-20 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent bg-gray-50 transition">
        <button class="absolute right-1.5 top-1/2 -translate-y-1/2 bg-[#1E7A4A] hover:bg-[#16633c] text-white px-4 py-1 rounded-md text-sm font-medium transition">Search</button>
    </div>
</div>