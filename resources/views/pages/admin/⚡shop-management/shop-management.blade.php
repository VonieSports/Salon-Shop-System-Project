<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Shops & Owners</h1>
        <p class="text-sm text-gray-500 mt-1">All registered businesses across headquarters and branches</p>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search shop, owner name, or email..."
                   class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400 transition bg-gray-50 focus:bg-white">
        </div>

        <select wire:model.live="typeFilter" class="px-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:ring-2 focus:ring-emerald-200">
            <option value="all">All Types</option>
            <option value="hq">Headquarters</option>
            <option value="branch">Branches</option>
        </select>

        <select wire:model.live="statusFilter" class="px-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:ring-2 focus:ring-emerald-200">
            <option value="all">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
        </select>
    </div>

    <!-- Grid of shop cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @forelse ($this->tenants as $tenant)
            @php
                $statusStyles = match ($tenant->verification_status) {
                    'approved' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'dot' => 'bg-emerald-500'],
                    'rejected' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'dot' => 'bg-red-500'],
                    default => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'dot' => 'bg-amber-500'],
                };
            @endphp
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                <div class="p-5">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-14 h-14 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center shrink-0 overflow-hidden">
                                @if ($tenant->logo)
                                    <img src="{{ Storage::url($tenant->logo) }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-lg font-bold text-emerald-600">{{ strtoupper(substr($tenant->name, 0, 1)) }}</span>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <p class="font-bold text-gray-900 truncate">{{ $tenant->name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ $tenant->email }}</p>
                            </div>
                        </div>
                        <span class="shrink-0 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $statusStyles['bg'] }} {{ $statusStyles['text'] }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $statusStyles['dot'] }}"></span>
                            {{ ucfirst($tenant->verification_status) }}
                        </span>
                    </div>

                    <div class="mt-4 flex items-center gap-2">
                        @if ($tenant->isBranch())
                            <span class="text-[11px] px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 font-medium">Branch of {{ $tenant->parentTenant?->name }}</span>
                        @else
                            <span class="text-[11px] px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 font-medium">Headquarters</span>
                        @endif
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-100 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center shrink-0 overflow-hidden">
                            @if ($tenant->owner?->avatar)
                                <img src="{{ Storage::url($tenant->owner->avatar) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-xs font-bold text-blue-700">{{ strtoupper(substr($tenant->owner?->name ?? 'U', 0, 1)) }}</span>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs font-medium text-gray-700 truncate">{{ $tenant->owner?->name ?? '—' }}</p>
                            <p class="text-[11px] text-gray-400 truncate">Manager</p>
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-3">
                        <div class="bg-gray-50 rounded-xl px-3 py-2 text-center">
                            <p class="text-sm font-bold text-gray-800">{{ $tenant->employees_count }}</p>
                            <p class="text-[10px] text-gray-400 uppercase tracking-wide">Employees</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl px-3 py-2 text-center">
                            <p class="text-sm font-bold text-gray-800">{{ $tenant->customers_count }}</p>
                            <p class="text-[10px] text-gray-400 uppercase tracking-wide">Customers</p>
                        </div>
                    </div>

                    <p class="text-[11px] text-gray-400 mt-3">Joined {{ $tenant->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl border border-gray-100 shadow-sm p-16 text-center text-gray-400 text-sm">
                No businesses found.
            </div>
        @endforelse
    </div>

    @if ($this->tenants->hasPages())
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-6 py-4">
            {{ $this->tenants->links() }}
        </div>
    @endif
</div>