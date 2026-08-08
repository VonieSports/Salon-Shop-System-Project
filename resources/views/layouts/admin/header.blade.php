<header class="bg-white border-b border-gray-200 h-[60px] sm:h-[68px] flex items-center px-3 sm:px-5 md:px-6 gap-3 sm:gap-4 shrink-0 z-20 sticky top-0 shadow-sm">
    <button @click="toggleSidebar()"
            class="lg:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition shrink-0">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    <div class="min-w-0">
        <p class="text-sm sm:text-base font-bold text-gray-900 truncate">{{ $title ?? 'Admin Panel' }}</p>
        <p class="text-xs text-gray-400 hidden sm:block">Platform oversight & moderation</p>
    </div>

    <div class="hidden lg:flex flex-1 items-center max-w-sm ml-6">
        <div class="relative w-full">
            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" placeholder="Search shops, owners..."
                   class="w-full pl-9 pr-3 py-2 text-sm border border-gray-200 rounded-lg bg-gray-50
                          focus:outline-none focus:bg-white focus:border-emerald-400 transition placeholder-gray-400">
        </div>
    </div>

    <div class="flex items-center gap-1.5 sm:gap-2.5 ml-auto shrink-0">

        <a href="{{ route('admin.business_approvals') }}" wire:navigate
           class="relative p-2 rounded-lg text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 transition"
           title="Pending Approvals">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            @if (($pendingApprovalCount ?? 0) > 0)
                <span class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">
                    {{ $pendingApprovalCount }}
                </span>
            @endif
        </a>

        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                class="flex items-center gap-1.5 px-1.5 py-1 rounded-lg hover:bg-gray-100 transition">
                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center shrink-0 border-2 border-emerald-200 overflow-hidden">
                    @if (Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-sm font-bold text-emerald-700">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                    @endif
                </div>
                <span class="hidden sm:block text-sm font-medium text-gray-700 truncate max-w-[100px]">{{ Auth::user()->name }}</span>
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
                <a href="{{ route('admin.profile') }}" wire:navigate
                   class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition font-medium">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    My Profile
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