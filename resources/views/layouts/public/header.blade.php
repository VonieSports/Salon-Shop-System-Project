<div>
<div class="bg-[#1E7A4A] text-white text-xs">
  <div class="max-w-[1700px] mx-auto px-4 sm:px-6 lg:px-10 py-3 flex flex-wrap items-center justify-between gap-2">
    <div class="flex items-center gap-3 sm:gap-5 flex-wrap">
      <a href="#" class="hover:underline whitespace-nowrap">Customer Service</a>
      <span class="opacity-40 hidden xs:inline">|</span>
      <span class="hidden sm:flex items-center gap-1">
        <span class="opacity-40 mx-1">|</span>
        <a href="{{ route('owner.login.page') }}" class="hover:underline whitespace-nowrap">Seller Centre</a>
         <span class="opacity-40 mx-1">|</span>
       <a href="{{ route('owner.register.page') }}" class="hover:underline whitespace-nowrap">Become a Seller</a>
      </span>
    </div>
    <div class="flex items-center gap-2 sm:gap-4">
      <span class="text-white/80 text-xs font-medium">Follow us:</span>
      <a href="#" class="text-white/80 hover:text-white transition-colors" aria-label="YouTube">
        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24">
          <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
        </svg>
      </a>
      <a href="#" class="text-white/80 hover:text-white transition-colors" aria-label="Instagram">
        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1 1 12.324 0 6.162 6.162 0 0 1-12.324 0zM12 16a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm4.965-10.405a1.44 1.44 0 1 1 2.881.001 1.44 1.44 0 0 1-2.881-.001z"/>
        </svg>
      </a>
      <a href="#" class="text-white/80 hover:text-white transition-colors" aria-label="Facebook">
        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24">
          <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
        </svg>
      </a>
      <a href="#" class="text-white/80 hover:text-white transition-colors" aria-label="Twitter">
        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24">
          <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
        </svg>
      </a>
    </div>
  </div>
</div>

<header class="bg-white border-b border-gray-100 relative z-50">
  <div class="max-w-[1700px] mx-auto px-4 sm:px-6 lg:px-10 py-3 sm:py-4 flex items-center gap-3 sm:gap-6">
    <button id="menuToggle" type="button" class="lg:hidden flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 text-gray-700 hover:text-emerald-800 shrink-0 order-1">
      <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>

    <a href="#" class="flex items-center gap-2 shrink-0 order-2 lg:order-1">
      <svg class="w-6 h-6 sm:w-7 sm:h-7 text-emerald-800" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c-1.5 2-4 3-4 6a4 4 0 008 0c0-3-2.5-4-4-6z"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 13v8M9 18h6"/>
      </svg>
      <span class="font-serif-display text-xl sm:text-2xl font-bold text-emerald-800 tracking-tight whitespace-nowrap">Style Station</span>
    </a>

    <nav class="hidden lg:flex items-center justify-center flex-1 gap-5 xl:gap-7 text-sm font-medium text-gray-700 order-2">
      <a href="#" class="relative py-1 hover:text-emerald-800 transition">Home<span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-emerald-800 rounded-full opacity-0 hover:opacity-100"></span></a>
      <a href="#" class="relative py-1 hover:text-emerald-800 transition">Shop<span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-emerald-800 rounded-full opacity-0 hover:opacity-100"></span></a>
      <a href="#" class="relative py-1 hover:text-emerald-800 transition">New Arrivals<span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-emerald-800 rounded-full opacity-0 hover:opacity-100"></span></a>
      <a href="#" class="relative py-1 hover:text-emerald-800 transition">Best Seller<span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-emerald-800 rounded-full opacity-0 hover:opacity-100"></span></a>
      <a href="#" class="relative py-1 hover:text-emerald-800 transition flex items-center gap-1">Categories<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg><span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-emerald-800 rounded-full opacity-0 hover:opacity-100"></span></a>
      <a href="#" class="relative py-1 hover:text-emerald-800 transition">About<span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-emerald-800 rounded-full opacity-0 hover:opacity-100"></span></a>
      <a href="#" class="relative py-1 hover:text-emerald-800 transition">Contact<span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-emerald-800 rounded-full opacity-0 hover:opacity-100"></span></a>
    </nav>

    <div class="flex items-center gap-2 sm:gap-4 shrink-0 ml-auto order-3">
      <!-- Search: icon-triggered dropdown, only shown below desktop where the persistent bar (below) takes over -->
      <button id="searchToggle" class="lg:hidden text-gray-700 hover:text-emerald-800 transition" aria-label="Open search">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
      </button>

      <!-- Persistent compact search bar, desktop only -->
      <div class="hidden lg:flex relative">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input type="text" placeholder="Search..." class="w-36 xl:w-48 pl-9 pr-3 py-1.5 text-sm border border-gray-200 rounded-full bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition">
      </div>

      <!-- Favorite / Wishlist -->
      <button class="text-gray-700 hover:text-emerald-800 transition relative" aria-label="Wishlist">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
        </svg>
        <span class="absolute -top-1 -right-1 bg-rose-500 text-white text-[10px] rounded-full w-4 h-4 flex items-center justify-center font-bold">2</span>
      </button>

      <!-- Cart -->
      <button class="text-gray-700 hover:text-emerald-800 transition relative" aria-label="Cart">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
        </svg>
        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] rounded-full w-4 h-4 flex items-center justify-center font-bold">3</span>
      </button>

      <!-- Notifications -->
      <button class="text-gray-700 hover:text-emerald-800 transition relative" aria-label="Notifications">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        <span class="absolute -top-1 -right-1 bg-emerald-600 text-white text-[10px] rounded-full w-4 h-4 flex items-center justify-center font-bold">5</span>
      </button>

      <a href="{{ route('login.page') }}" class="hidden sm:block bg-[#1E7A4A] hover:bg-emerald-800 transition text-white text-sm font-medium px-4 sm:px-6 py-2 sm:py-2.5 rounded-md whitespace-nowrap">Sign in</a>
      <a href="{{ route('login.page') }}" class="lg:hidden bg-[#1E7A4A] hover:bg-emerald-800 transition text-white text-sm font-medium px-3 py-1.5 sm:px-4 sm:py-2 rounded-md whitespace-nowrap">Sign in</a>
    </div>
  </div>

  <div id="mobileMenu" class="hidden lg:hidden border-t border-gray-100 bg-white">
    <div class="px-4 sm:px-6 py-4 space-y-3">
      <nav class="flex flex-col space-y-2 text-sm font-medium text-gray-700">
        <a href="#" class="py-2 hover:text-emerald-800 transition border-b border-gray-50">Home</a>
        <a href="#" class="py-2 hover:text-emerald-800 transition border-b border-gray-50">Shop</a>
        <a href="#" class="py-2 hover:text-emerald-800 transition border-b border-gray-50">New Arrivals</a>
        <a href="#" class="py-2 hover:text-emerald-800 transition border-b border-gray-50">Best Seller</a>
        <a href="#" class="py-2 hover:text-emerald-800 transition border-b border-gray-50 flex items-center justify-between">Categories<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg></a>
        <a href="#" class="py-2 hover:text-emerald-800 transition border-b border-gray-50">About</a>
        <a href="#" class="py-2 hover:text-emerald-800 transition">Contact</a>
         <a href="#" class="py-2 hover:text-emerald-800 transition border-b border-gray-50">Seller Centre</a>
        <a href="#" class="py-2 hover:text-emerald-800 transition">Become a Seller</a>
      </nav>

      <div class="pt-4 border-t border-gray-100">
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

      <a href="#" class="block w-full bg-[#1E7A4A] hover:bg-emerald-800 text-white text-sm font-medium px-6 py-2.5 rounded-md text-center mt-3">Sign in</a>
    </div>
  </div>

  <!-- Compact centered search dropdown (YouTube-style) -->
  <div id="searchDropdown" class="hidden fixed inset-0 z-[100]">
    <div id="searchBackdrop" class="absolute inset-0 bg-gray-900/30 backdrop-blur-sm"></div>

    <div class="relative flex justify-center px-4 pt-20 sm:pt-24">
      <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">
        <div class="flex items-center gap-2 px-4 py-3 border-b border-gray-100">
          <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
          <input id="searchInput" type="text" placeholder="Search products, services..." class="flex-1 text-sm focus:outline-none">
          <button id="searchClose" class="p-1 text-gray-400 hover:text-gray-600 shrink-0" aria-label="Close search">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>

        <div class="px-4 py-4">
          <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Recent searches</p>
          <div class="flex flex-wrap gap-2">
            <button type="button" class="search-suggestion bg-gray-100 hover:bg-gray-200 transition px-3 py-1.5 rounded-full text-sm text-gray-700">Hair salon</button>
            <button type="button" class="search-suggestion bg-gray-100 hover:bg-gray-200 transition px-3 py-1.5 rounded-full text-sm text-gray-700">Nail art</button>
            <button type="button" class="search-suggestion bg-gray-100 hover:bg-gray-200 transition px-3 py-1.5 rounded-full text-sm text-gray-700">Skincare</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>

</div>

<script>
// Mobile hamburger menu
function toggleMenu() {
  document.getElementById('mobileMenu').classList.toggle('hidden');
}

// Search dropdown
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

document.getElementById('menuToggle').addEventListener('click', toggleMenu);
document.getElementById('searchToggle').addEventListener('click', openSearch);
document.getElementById('searchClose').addEventListener('click', closeSearch);
document.getElementById('searchBackdrop').addEventListener('click', closeSearch);

document.getElementById('searchInput').addEventListener('keydown', function (e) {
  if (e.key === 'Enter') doSearch();
  if (e.key === 'Escape') closeSearch();
});

// Clicking a recent-search chip fills the input and searches immediately
document.querySelectorAll('.search-suggestion').forEach(function (chip) {
  chip.addEventListener('click', function () {
    document.getElementById('searchInput').value = chip.textContent.trim();
    doSearch();
  });
});
</script>