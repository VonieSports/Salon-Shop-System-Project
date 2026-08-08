<aside class="flex flex-col h-full w-64 bg-white overflow-x-hidden">
    <!-- Brand -->
    <div class="flex items-center gap-3 px-4 py-4 border-b border-gray-200 shrink-0">
        <div class="w-9 h-9 rounded-lg bg-[#1E7A4A] flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="min-w-0">
            <span class="font-bold text-lg text-gray-800 tracking-tight block leading-tight">BeautyNova</span>
            <span class="text-[10px] font-semibold text-[#1E7A4A] uppercase tracking-wider">Admin Panel</span>
        </div>
    </div>

    <!-- Admin identity -->
    <div class="px-4 py-4 border-b border-gray-100 shrink-0">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center shrink-0 overflow-hidden">
                @if (auth()->user()?->avatar)
                    <img src="{{ Storage::url(auth()->user()->avatar) }}" class="w-full h-full object-cover">
                @else
                    <span class="text-sm font-bold text-emerald-700">
                        {{ strtoupper(substr(auth()->user()?->name ?? 'A', 0, 1)) }}
                    </span>
                @endif
            </div>
            <div class="min-w-0">
                <p class="text-sm font-semibold text-gray-800 truncate">{{ auth()->user()?->name }}</p>
                <p class="text-xs text-gray-500 truncate">{{ auth()->user()?->email }}</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto px-3 py-3 space-y-1">
        <a href="{{ route('admin.dashboard') }}" wire:navigate
           class="sidebar-item flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 ease-in-out {{ request()->routeIs('admin.dashboard') ? 'bg-[#1E7A4A]/10 text-[#1E7A4A]' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}"
           @click="if(window.innerWidth < 1024) sidebarOpen = false">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Dashboard
        </a>

        <div x-data="{ open: localStorage.getItem('adminBusinessOpen') !== 'false' }"
             x-init="$watch('open', val => localStorage.setItem('adminBusinessOpen', val))"
             class="pt-2 border-t border-gray-100">
            <div @click="open = !open"
                 class="flex items-center justify-between px-4 py-2 rounded-lg text-[10px] font-bold uppercase tracking-wider cursor-pointer select-none transition-colors duration-200 text-gray-400 hover:text-gray-600">
                <span>Business Oversight</span>
                <svg class="w-4 h-4 transition-transform duration-300 ease-in-out"
                     :class="open ? 'rotate-180' : ''"
                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>

            <div x-show="open" x-collapse.duration.300ms class="mt-1 ml-2 pl-3 border-l-2 border-gray-200 flex flex-col gap-0.5">
                <a href="{{ route('admin.business_approvals') }}" wire:navigate
                   class="sidebar-item flex items-center justify-between gap-2 px-4 py-2.5 pl-9 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out {{ request()->routeIs('admin.approvals') ? 'bg-[#1E7A4A]/10 text-[#1E7A4A]' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <span class="flex items-center gap-3.5">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Pending Approvals
                    </span>
                    @if (($pendingApprovalCount ?? 0) > 0)
                        <span class="shrink-0 inline-flex items-center justify-center min-w-[18px] h-[18px] px-1 rounded-full bg-amber-500 text-white text-[10px] font-bold">
                            {{ $pendingApprovalCount }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('admin.shop_management') }}" wire:navigate
                   class="sidebar-item flex items-center gap-3.5 px-4 py-2.5 pl-9 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out {{ request()->routeIs('admin.tenants') ? 'bg-[#1E7A4A]/10 text-[#1E7A4A]' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Shops & Owners
                </a>
            </div>
        </div>

        <!-- USERS -->
        <div x-data="{ open: localStorage.getItem('adminUsersOpen') !== 'false' }"
             x-init="$watch('open', val => localStorage.setItem('adminUsersOpen', val))"
             class="pt-2 border-t border-gray-100">
            <div @click="open = !open"
                 class="flex items-center justify-between px-4 py-2 rounded-lg text-[10px] font-bold uppercase tracking-wider cursor-pointer select-none transition-colors duration-200 text-gray-400 hover:text-gray-600">
                <span>Users</span>
                <svg class="w-4 h-4 transition-transform duration-300 ease-in-out"
                     :class="open ? 'rotate-180' : ''"
                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>

            <div x-show="open" x-collapse.duration.300ms class="mt-1 ml-2 pl-3 border-l-2 border-gray-200 flex flex-col gap-0.5">
                <a href="{{ route('admin.shop_customer') }}" wire:navigate
                   class="sidebar-item flex items-center gap-3.5 px-4 py-2.5 pl-9 rounded-lg text-sm font-medium transition-all duration-200 ease-in-out {{ request()->routeIs('admin.customers') ? 'bg-[#1E7A4A]/10 text-[#1E7A4A]' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Customers
                </a>
            </div>
        </div>
    </nav>

    <div class="border-t border-gray-100 px-3 py-3 space-y-1 shrink-0">
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
</aside>