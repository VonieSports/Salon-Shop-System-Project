<div>

<!-- Top utility bar -->
<div class="bg-[#1E7A4A] text-white text-xs">
  <div class="max-w-[1700px] mx-auto px-6 lg:px-10 py-3 flex items-center justify-between">
    <div class="flex items-center gap-5">
      <a href="#" class="hover:underline">Customer Service</a>
      <span class="opacity-40">|</span>
      <span>Contact Us <a href="tel:+639096575772" class="underline font-medium">020390 657 5772</a></span>
    </div>
    <div class="flex items-center gap-5">
      <a href="#" class="hover:underline">Sign in</a>
    </div>
  </div>
</div>

<!-- Header / Nav -->
<header class="bg-white border-b border-gray-100 relative z-50">
  <div class="max-w-[1700px] mx-auto px-6 lg:px-10 py-4 flex items-center gap-6">
    
    <!-- Logo -->
    <a href="#" class="flex items-center gap-2 shrink-0">
      <svg class="w-7 h-7 text-emerald-800" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c-1.5 2-4 3-4 6a4 4 0 008 0c0-3-2.5-4-4-6z"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 13v8M9 18h6"/>
      </svg>
      <span class="font-serif-display text-2xl font-bold text-emerald-800 tracking-tight">Style Station</span>
    </a>

    <!-- Nav links - centered with active state -->
    <nav class="hidden lg:flex items-center justify-center flex-1 gap-7 text-sm font-medium text-gray-700">
      <a href="#" class="relative py-1 hover:text-emerald-800 transition 
                         {{ request()->is('/') ? 'text-emerald-800' : '' }}">
        Home
        <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-emerald-800 rounded-full 
                     {{ request()->is('/') ? 'opacity-100' : 'opacity-0 hover:opacity-100' }}"></span>
      </a>
      <a href="#" class="relative py-1 hover:text-emerald-800 transition 
                         {{ request()->is('shop*') ? 'text-emerald-800' : '' }}">
        Shop
        <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-emerald-800 rounded-full 
                     {{ request()->is('shop*') ? 'opacity-100' : 'opacity-0 hover:opacity-100' }}"></span>
      </a>
      <a href="#" class="relative py-1 hover:text-emerald-800 transition 
                         {{ request()->is('new-arrivals*') ? 'text-emerald-800' : '' }}">
        New Arrivals
        <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-emerald-800 rounded-full 
                     {{ request()->is('new-arrivals*') ? 'opacity-100' : 'opacity-0 hover:opacity-100' }}"></span>
      </a>
      <a href="#" class="relative py-1 hover:text-emerald-800 transition 
                         {{ request()->is('best-seller*') ? 'text-emerald-800' : '' }}">
        Best Seller
        <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-emerald-800 rounded-full 
                     {{ request()->is('best-seller*') ? 'opacity-100' : 'opacity-0 hover:opacity-100' }}"></span>
      </a>
      <a href="#" class="relative py-1 hover:text-emerald-800 transition flex items-center gap-1
                         {{ request()->is('categories*') ? 'text-emerald-800' : '' }}">
        Categories
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
        </svg>
        <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-emerald-800 rounded-full 
                     {{ request()->is('categories*') ? 'opacity-100' : 'opacity-0 hover:opacity-100' }}"></span>
      </a>
      <a href="#" class="relative py-1 hover:text-emerald-800 transition 
                         {{ request()->is('about*') ? 'text-emerald-800' : '' }}">
        About
        <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-emerald-800 rounded-full 
                     {{ request()->is('about*') ? 'opacity-100' : 'opacity-0 hover:opacity-100' }}"></span>
      </a>
      <a href="#" class="relative py-1 hover:text-emerald-800 transition 
                         {{ request()->is('contact*') ? 'text-emerald-800' : '' }}">
        Contact
        <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-emerald-800 rounded-full 
                     {{ request()->is('contact*') ? 'opacity-100' : 'opacity-0 hover:opacity-100' }}"></span>
      </a>
    </nav>

    <!-- Right side - Icons + Sign in -->
    <div class="flex items-center gap-4 shrink-0">
      <!-- Search icon -->
      <button class="text-gray-700 hover:text-emerald-800 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
      </button>
      
      <!-- Heart icon -->
      <button class="text-gray-700 hover:text-emerald-800 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
        </svg>
      </button>
      
      <!-- Cart icon -->
      <button class="text-gray-700 hover:text-emerald-800 transition relative">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
        </svg>
        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] rounded-full w-4 h-4 flex items-center justify-center font-bold">3</span>
      </button>
      
      <!-- Bell icon -->
      <button class="text-gray-700 hover:text-emerald-800 transition relative">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        <span class="absolute -top-1 -right-1 w-2 h-2 bg-emerald-600 rounded-full"></span>
      </button>
      
      <!-- Sign in button -->
      <a href="{{ route('login.page') }}" class="bg-[#1E7A4A] hover:bg-emerald-800 transition text-white text-sm font-medium px-6 py-2.5 rounded-md whitespace-nowrap">
        Sign in
      </a>
    </div>

    <!-- Hamburger (mobile) -->
    <button id="menu-toggle" type="button" class="lg:hidden flex items-center justify-center w-10 h-10 text-gray-700 hover:text-emerald-800" aria-label="Toggle menu" aria-expanded="false">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>
  </div>

  <!-- Mobile menu panel -->
  <div id="mobile-menu" class="hidden lg:hidden border-t border-gray-100 bg-white">
    <div class="px-6 py-4 space-y-3">
      <nav class="flex flex-col space-y-2 text-sm font-medium text-gray-700">
        <a href="#" class="py-2 hover:text-emerald-800 transition border-b border-gray-50">Home</a>
        <a href="#" class="py-2 hover:text-emerald-800 transition border-b border-gray-50">Shop</a>
        <a href="#" class="py-2 hover:text-emerald-800 transition border-b border-gray-50">New Arrivals</a>
        <a href="#" class="py-2 hover:text-emerald-800 transition border-b border-gray-50">Best Seller</a>
        <a href="#" class="py-2 hover:text-emerald-800 transition border-b border-gray-50 flex items-center justify-between">
          Categories
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
          </svg>
        </a>
        <a href="#" class="py-2 hover:text-emerald-800 transition border-b border-gray-50">About</a>
        <a href="#" class="py-2 hover:text-emerald-800 transition">Contact</a>
      </nav>
      
      <!-- Mobile icons row -->
      <div class="flex items-center gap-6 pt-2 text-gray-700">
        <button class="flex items-center gap-2 text-sm hover:text-emerald-800 transition">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
          Search
        </button>
        <button class="flex items-center gap-2 text-sm hover:text-emerald-800 transition">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
          </svg>
          Wishlist
        </button>
        <button class="flex items-center gap-2 text-sm hover:text-emerald-800 transition relative">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
          </svg>
          Cart
          <span class="bg-red-500 text-white text-[10px] rounded-full w-4 h-4 flex items-center justify-center font-bold absolute -top-1 left-5">3</span>
        </button>
        <button class="flex items-center gap-2 text-sm hover:text-emerald-800 transition">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
          </svg>
          Alerts
        </button>
      </div>
      
      <a href="{{ route('login.page') }}" class="block w-full bg-[#1E7A4A] hover:bg-emerald-800 text-white text-sm font-medium px-6 py-2.5 rounded-md text-center">
        Sign in
      </a>
    </div>
  </div>
</header>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
});
</script>