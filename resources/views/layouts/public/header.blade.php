<!-- Top bar - hidden on mobile, shown on tablet+ -->
<div class="hidden sm:block bg-[#1E7A4A] text-white text-xs">
  <div class="max-w-[1700px] mx-auto px-4 sm:px-6 lg:px-10 py-2.5 flex flex-wrap items-center justify-between gap-2">
    <div class="flex items-center gap-3 sm:gap-5 flex-wrap">
      <a href="#" class="hover:underline whitespace-nowrap text-white/90 hover:text-white transition">Customer Service</a>
      <span class="text-white/30 hidden xs:inline">|</span>
      <span class="hidden md:flex items-center gap-1 text-white/80">
        <span class="text-white/30 mx-1">|</span>
        <a href="{{ route('owner.login.page') }}" class="hover:text-white transition whitespace-nowrap">Seller Centre</a>
        <span class="text-white/30 mx-1">|</span>
        <a href="{{ route('owner.register.page') }}" class="hover:text-white transition whitespace-nowrap">Become a Seller</a>
      </span>
    </div>
    <div class="flex items-center gap-2 sm:gap-4">
      <span class="text-white/70 text-[11px] sm:text-xs font-medium hidden xs:inline">Follow us:</span>
      <div class="flex items-center gap-1.5 sm:gap-2">
        <a href="#" class="text-white/60 hover:text-white transition-colors p-1" aria-label="YouTube">
          <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
          </svg>
        </a>
        <a href="#" class="text-white/60 hover:text-white transition-colors p-1" aria-label="Instagram">
          <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1 1 12.324 0 6.162 6.162 0 0 1-12.324 0zM12 16a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm4.965-10.405a1.44 1.44 0 1 1 2.881.001 1.44 1.44 0 0 1-2.881-.001z"/>
          </svg>
        </a>
        <a href="#" class="text-white/60 hover:text-white transition-colors p-1" aria-label="Facebook">
          <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
          </svg>
        </a>
        <a href="#" class="text-white/60 hover:text-white transition-colors p-1" aria-label="Twitter">
          <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
          </svg>
        </a>
      </div>
    </div>
  </div>
</div>

<header class="bg-white border-b border-gray-100 shadow-sm relative z-50">
  <div class="max-w-[1700px] mx-auto px-3 sm:px-6 lg:px-10">
    <!-- Mobile layout (sm and below) -->
    <div class="flex items-center justify-between h-14 sm:h-16 lg:hidden">
      <!-- Left: Menu + Logo -->
      <div class="flex items-center gap-2 min-w-0 flex-1">
        <button id="menuToggle" type="button" class="flex items-center justify-center w-8 h-8 text-gray-700 hover:text-emerald-800 hover:bg-emerald-50 rounded-lg transition shrink-0">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>

        <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-1.5 shrink-0">
          <svg class="w-5 h-5 text-emerald-800" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c-1.5 2-4 3-4 6a4 4 0 008 0c0-3-2.5-4-4-6z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 13v8M9 18h6"/>
          </svg>
          <span class="font-serif-display text-base sm:text-lg font-bold text-emerald-800 tracking-tight whitespace-nowrap">Style Station</span>
        </a>
      </div>

      <!-- Right: Icons + Auth (Mobile) -->
      <div class="flex items-center gap-0.5">
        <button id="searchToggleMobile" class="text-gray-700 hover:text-emerald-800 hover:bg-emerald-50 p-1.5 rounded-lg transition" aria-label="Open search">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
        </button>

        <button class="text-gray-700 hover:text-emerald-800 hover:bg-emerald-50 p-1.5 rounded-lg transition relative" aria-label="Wishlist">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
          </svg>
          <span class="absolute -top-0.5 -right-0.5 bg-rose-500 text-white text-[9px] rounded-full w-4 h-4 flex items-center justify-center font-bold shadow-sm border border-white">2</span>
        </button>

        <a href="{{ route('customer.cart') }}" class="text-gray-700 hover:text-emerald-800 hover:bg-emerald-50 p-1.5 rounded-lg transition relative" aria-label="Cart">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
          </svg>
          <span class="absolute -top-0.5 -right-0.5 bg-red-500 text-white text-[9px] rounded-full w-4 h-4 flex items-center justify-center font-bold shadow-sm border border-white">3</span>
        </a>

        <button class="hidden xs:flex text-gray-700 hover:text-emerald-800 hover:bg-emerald-50 p-1.5 rounded-lg transition relative" aria-label="Notifications">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
          </svg>
          <span class="absolute -top-0.5 -right-0.5 bg-emerald-600 text-white text-[9px] rounded-full w-4 h-4 flex items-center justify-center font-bold shadow-sm border border-white">5</span>
        </button>

        @auth
            <div class="relative ml-0.5" x-data="{ open: false }" @click.away="open = false">
                <button @click="open = !open" class="flex items-center gap-1 pl-0.5 pr-1 py-0.5 rounded-full hover:bg-gray-50 transition-colors">
                    <div class="w-7 h-7 rounded-full bg-[#1E7A4A] flex items-center justify-center text-white text-xs font-bold border-2 border-white shadow-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </button>
                <div x-show="open" x-cloak
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     class="absolute right-0 mt-2 w-40 bg-white rounded-xl shadow-xl border border-gray-100 z-50 py-1">
                    <div class="px-4 py-2 border-b border-gray-100">
                        <p class="text-xs font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                    </div>
                    <a href="{{ route('customer.update_profile') }}" class="block px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition">Profile</a>
                    <a href="{{ route('customer.order_history') }}" class="block px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition">My Orders</a>
                    <div class="border-t border-gray-100 my-1"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50 transition">Sign Out</button>
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}" class="bg-[#1E7A4A] hover:bg-emerald-800 active:bg-emerald-900 transition text-white text-xs font-medium px-2.5 py-1.5 rounded-lg whitespace-nowrap ml-0.5">
                Sign in
            </a>
        @endauth
      </div>
    </div>

    <!-- Desktop layout (lg and above) -->
    <div class="hidden lg:flex items-center justify-between h-[88px]">
      <!-- Left: Logo -->
      <div class="flex items-center gap-3">
        <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-2 shrink-0">
          <svg class="w-8 h-8 text-emerald-800" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c-1.5 2-4 3-4 6a4 4 0 008 0c0-3-2.5-4-4-6z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 13v8M9 18h6"/>
          </svg>
          <span class="font-serif-display text-3xl font-bold text-emerald-800 tracking-tight">Style Station</span>
        </a>
      </div>

      <!-- Center: Navigation -->
      <nav class="flex items-center justify-center flex-1 gap-6 xl:gap-8 text-sm font-medium text-gray-700 px-4">
        <a href="{{ route('customer.dashboard') }}" class="relative py-2 hover:text-emerald-800 transition group">
          Home
          <span class="absolute -bottom-0.5 left-0 right-0 h-0.5 bg-emerald-800 rounded-full transform scale-x-0 group-hover:scale-x-100 transition-transform duration-200"></span>
        </a>
        <a href="#" class="relative py-2 hover:text-emerald-800 transition group">
          Shop
          <span class="absolute -bottom-0.5 left-0 right-0 h-0.5 bg-emerald-800 rounded-full transform scale-x-0 group-hover:scale-x-100 transition-transform duration-200"></span>
        </a>
        <a href="#" class="relative py-2 hover:text-emerald-800 transition group">
          New Arrivals
          <span class="absolute -bottom-0.5 left-0 right-0 h-0.5 bg-emerald-800 rounded-full transform scale-x-0 group-hover:scale-x-100 transition-transform duration-200"></span>
        </a>
        <a href="#" class="relative py-2 hover:text-emerald-800 transition group">
          Best Seller
          <span class="absolute -bottom-0.5 left-0 right-0 h-0.5 bg-emerald-800 rounded-full transform scale-x-0 group-hover:scale-x-100 transition-transform duration-200"></span>
        </a>
        <div class="relative group">
          <a href="#" class="relative py-2 hover:text-emerald-800 transition flex items-center gap-1 group">
            Categories
            <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
            <span class="absolute -bottom-0.5 left-0 right-0 h-0.5 bg-emerald-800 rounded-full transform scale-x-0 group-hover:scale-x-100 transition-transform duration-200"></span>
          </a>
          <div class="absolute left-0 top-full pt-2 w-48 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
            <div class="bg-white rounded-lg shadow-lg border border-gray-100 py-2">
              <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-800 transition">Hair Care</a>
              <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-800 transition">Skincare</a>
              <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-800 transition">Nail Art</a>
              <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-800 transition">Makeup</a>
            </div>
          </div>
        </div>
        <a href="#" class="relative py-2 hover:text-emerald-800 transition group">
          About
          <span class="absolute -bottom-0.5 left-0 right-0 h-0.5 bg-emerald-800 rounded-full transform scale-x-0 group-hover:scale-x-100 transition-transform duration-200"></span>
        </a>
        <a href="#" class="relative py-2 hover:text-emerald-800 transition group">
          Contact
          <span class="absolute -bottom-0.5 left-0 right-0 h-0.5 bg-emerald-800 rounded-full transform scale-x-0 group-hover:scale-x-100 transition-transform duration-200"></span>
        </a>
      </nav>

      <!-- Right: Search + Icons + Desktop Auth Block -->
      <div class="flex items-center gap-3">
        <!-- Search Bar -->
        <div class="relative w-48 xl:w-56">
          <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
          <input type="text" placeholder="Search products..." 
                 class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-opacity-50 focus:bg-white transition placeholder:text-gray-400">
        </div>

        <!-- ICONS ROW - PERFECTLY SPACED -->
        <div class="flex items-center gap-2 xl:gap-3 ml-1">
          <!-- Wishlist -->
          <a href="#" class="text-gray-700 hover:text-emerald-800 hover:bg-emerald-50 p-2 rounded-lg transition relative flex items-center justify-center" aria-label="Wishlist">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            <span class="absolute -top-1 -right-1 bg-rose-500 text-white text-[10px] rounded-full w-5 h-5 flex items-center justify-center font-bold shadow-sm border-2 border-white">2</span>
          </a>

          <!-- Cart -->
          <a href="{{ route('customer.cart') }}" class="text-gray-700 hover:text-emerald-800 hover:bg-emerald-50 p-2 rounded-lg transition relative flex items-center justify-center" aria-label="Cart">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] rounded-full w-5 h-5 flex items-center justify-center font-bold shadow-sm border-2 border-white">3</span>
          </a>

          <!-- Notifications -->
          <button class="text-gray-700 hover:text-emerald-800 hover:bg-emerald-50 p-2 rounded-lg transition relative flex items-center justify-center" aria-label="Notifications">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <span class="absolute -top-1 -right-1 bg-emerald-600 text-white text-[10px] rounded-full w-5 h-5 flex items-center justify-center font-bold shadow-sm border-2 border-white">5</span>
          </button>
        </div>

        <!-- UNIFIED DESKTOP AUTH BLOCK -->
        @auth
            <div class="relative ml-2" x-data="{ open: false }" @click.away="open = false">
                <button @click="open = !open" class="flex items-center gap-2 pl-1 pr-2 py-1 rounded-full hover:bg-gray-50 transition-colors">
                    <div class="w-9 h-9 rounded-full bg-[#1E7A4A] flex items-center justify-center text-white text-sm font-bold border-2 border-white shadow-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <span class="hidden xl:block text-sm font-medium text-gray-700 max-w-[80px] truncate">{{ Auth::user()->name }}</span>
                    <svg class="w-3 h-3 text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-cloak
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 z-50 py-1">
                    <div class="px-4 py-2 border-b border-gray-100">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    </div>
                    <a href="{{ route('customer.update_profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">My Profile</a>
                    <a href="{{ route('customer.order_history') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">My Orders</a>
                    <div class="border-t border-gray-100 my-1"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">Sign Out</button>
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}" class="bg-[#1E7A4A] hover:bg-emerald-800 active:bg-emerald-900 transition text-white text-sm font-medium px-6 py-2.5 rounded-lg whitespace-nowrap shadow-sm hover:shadow-md">
                Sign in
            </a>
        @endauth
      </div>
    </div>
  </div>

  <!-- Mobile Menu -->
  <div id="mobileMenu" class="hidden lg:hidden border-t border-gray-100 bg-white shadow-lg">
    <div class="px-4 py-4 space-y-1 max-h-[70vh] overflow-y-auto">
      <nav class="flex flex-col text-sm font-medium text-gray-700">
        <a href="{{ route('customer.dashboard') }}" class="py-3 hover:text-emerald-800 transition border-b border-gray-50 flex items-center justify-between">
          Home
          <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
          </svg>
        </a>
        <a href="#" class="py-3 hover:text-emerald-800 transition border-b border-gray-50 flex items-center justify-between">
          Shop
          <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
          </svg>
        </a>
        <a href="#" class="py-3 hover:text-emerald-800 transition border-b border-gray-50 flex items-center justify-between">
          New Arrivals
          <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
          </svg>
        </a>
        <a href="#" class="py-3 hover:text-emerald-800 transition border-b border-gray-50 flex items-center justify-between">
          Best Seller
          <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
          </svg>
        </a>
        <div class="border-b border-gray-50">
          <button onclick="toggleMobileCategories()" class="w-full py-3 hover:text-emerald-800 transition flex items-center justify-between">
            Categories
            <svg id="mobileCategoryArrow" class="w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7 7"/>
            </svg>
          </button>
          <div id="mobileCategories" class="hidden pl-4 pb-2 space-y-1">
            <a href="#" class="block py-2 text-sm text-gray-600 hover:text-emerald-800 transition">Hair Care</a>
            <a href="#" class="block py-2 text-sm text-gray-600 hover:text-emerald-800 transition">Skincare</a>
            <a href="#" class="block py-2 text-sm text-gray-600 hover:text-emerald-800 transition">Nail Art</a>
            <a href="#" class="block py-2 text-sm text-gray-600 hover:text-emerald-800 transition">Makeup</a>
          </div>
        </div>
        <a href="#" class="py-3 hover:text-emerald-800 transition border-b border-gray-50 flex items-center justify-between">
          About
          <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
          </svg>
        </a>
        <a href="#" class="py-3 hover:text-emerald-800 transition flex items-center justify-between">
          Contact
          <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
          </svg>
        </a>
      </nav>

      <div class="mt-4 pt-4 border-t border-gray-100 flex flex-col gap-2">
        @auth
            <div class="flex items-center gap-3 px-2 py-2 border-b border-gray-50">
                <div class="w-10 h-10 rounded-full bg-[#1E7A4A] flex items-center justify-center text-white text-sm font-bold shadow-sm">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <a href="{{ route('customer.order_history') }}" class="block w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium px-6 py-2.5 rounded-lg transition">My Orders</a>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="block w-full text-center bg-red-50 hover:bg-red-100 text-red-700 text-sm font-medium px-6 py-2.5 rounded-lg transition">Sign Out</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="block w-full text-center bg-[#1E7A4A] hover:bg-emerald-800 text-white text-sm font-medium px-6 py-2.5 rounded-lg transition">Sign In</a>
            <a href="{{ route('owner.login.page') }}" class="block w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium px-6 py-2.5 rounded-lg transition">Seller Centre</a>
            <a href="{{ route('owner.register.page') }}" class="block w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium px-6 py-2.5 rounded-lg transition">Become a Seller</a>
        @endauth
      </div>

      <div class="mt-4 pt-4 border-t border-gray-100">
        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-3">Follow us</p>
        <div class="flex items-center gap-4">
          <a href="#" class="text-gray-600 hover:text-emerald-800 transition-colors" aria-label="YouTube">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
            </svg>
          </a>
          <a href="#" class="text-gray-600 hover:text-emerald-800 transition-colors" aria-label="Instagram">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1 1 12.324 0 6.162 6.162 0 0 1-12.324 0zM12 16a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm4.965-10.405a1.44 1.44 0 1 1 2.881.001 1.44 1.44 0 0 1-2.881-.001z"/>
            </svg>
          </a>
          <a href="#" class="text-gray-600 hover:text-emerald-800 transition-colors" aria-label="Facebook">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
            </svg>
          </a>
          <a href="#" class="text-gray-600 hover:text-emerald-800 transition-colors" aria-label="Twitter">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
            </svg>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Search Dropdown -->
  <div id="searchDropdown" class="hidden fixed inset-0 z-[100]">
    <div id="searchBackdrop" class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm"></div>

    <div class="relative flex justify-center px-4 pt-16 sm:pt-20">
      <div class="w-full max-w-2xl bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden animate-slideDown">
        <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100">
          <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
          <input id="searchInput" type="text" placeholder="Search products, services..." 
                 class="flex-1 text-base sm:text-lg focus:outline-none py-1">
          <button id="searchClose" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition shrink-0" aria-label="Close search">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>

        <div class="px-5 py-4">
          <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-3">Popular searches</p>
          <div class="flex flex-wrap gap-2">
            <button type="button" class="search-suggestion bg-gray-100 hover:bg-gray-200 transition px-4 py-2 rounded-full text-sm text-gray-700">Hair salon</button>
            <button type="button" class="search-suggestion bg-gray-100 hover:bg-gray-200 transition px-4 py-2 rounded-full text-sm text-gray-700">Nail art</button>
            <button type="button" class="search-suggestion bg-gray-100 hover:bg-gray-200 transition px-4 py-2 rounded-full text-sm text-gray-700">Skincare</button>
            <button type="button" class="search-suggestion bg-gray-100 hover:bg-gray-200 transition px-4 py-2 rounded-full text-sm text-gray-700">Makeup</button>
            <button type="button" class="search-suggestion bg-gray-100 hover:bg-gray-200 transition px-4 py-2 rounded-full text-sm text-gray-700">Hair tools</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>

<style>
@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-20px) scale(0.95);
  }
  to {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}
.animate-slideDown {
  animation: slideDown 0.2s ease-out;
}

@media (max-width: 375px) {
  .header-logo-text {
    font-size: 14px !important;
  }
  .header-icons {
    gap: 2px !important;
  }
}
</style>

<script>
document.getElementById('menuToggle').addEventListener('click', function() {
  const menu = document.getElementById('mobileMenu');
  menu.classList.toggle('hidden');
});

function toggleMobileCategories() {
  const categories = document.getElementById('mobileCategories');
  const arrow = document.getElementById('mobileCategoryArrow');
  categories.classList.toggle('hidden');
  arrow.classList.toggle('rotate-180');
}

function openSearch() {
  document.getElementById('searchDropdown').classList.remove('hidden');
  document.body.style.overflow = 'hidden';
  setTimeout(() => document.getElementById('searchInput').focus(), 50);
}

function closeSearch() {
  document.getElementById('searchDropdown').classList.add('hidden');
  document.body.style.overflow = '';
  document.getElementById('searchInput').value = '';
}

function doSearch() {
  const query = document.getElementById('searchInput').value.trim();
  if (query) {
    alert('Searching for: "' + query + '"');
    closeSearch();
  }
}

document.querySelectorAll('#searchToggle, #searchToggleMobile').forEach(function(btn) {
  btn.addEventListener('click', openSearch);
});

document.getElementById('searchClose').addEventListener('click', closeSearch);
document.getElementById('searchBackdrop').addEventListener('click', closeSearch);

document.getElementById('searchInput').addEventListener('keydown', function(e) {
  if (e.key === 'Enter') doSearch();
  if (e.key === 'Escape') closeSearch();
});
 
document.querySelectorAll('.search-suggestion').forEach(function(chip) {
  chip.addEventListener('click', function() {
    document.getElementById('searchInput').value = chip.textContent.trim();
    doSearch();
  });
});

document.addEventListener('click', function(e) {
  const menu = document.getElementById('mobileMenu');
  const toggle = document.getElementById('menuToggle');
  if (!menu.classList.contains('hidden') && 
      !menu.contains(e.target) && 
      !toggle.contains(e.target)) {
    menu.classList.add('hidden');
  }
});

document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    document.getElementById('mobileMenu').classList.add('hidden');
    closeSearch();
  }
});
</script>