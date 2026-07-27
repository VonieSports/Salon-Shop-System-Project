
@php
    $tenant = Auth::user()->tenant;
@endphp

<div class="px-4 py-4 border-b border-gray-100 shrink-0">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0 overflow-hidden">
            @if($tenant && $tenant->logo && $tenant->business_setup_completed)
                <img src="{{ Storage::url($tenant->logo) }}" class="w-full h-full object-cover">
            @else
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            @endif
        </div>
        <div class="min-w-0">
            @if($tenant && $tenant->business_setup_completed && $tenant->name)
                <p class="text-sm font-semibold text-gray-800 truncate">{{ $tenant->name }}</p>
                <p class="text-xs text-gray-500 truncate">{{ $tenant->email ?? 'No business email' }}</p>
            @else
                <p class="text-sm font-semibold text-gray-400 truncate">No Business Setup</p>
                <p class="text-xs text-gray-400 truncate">Complete your business setup</p>
            @endif
        </div>
    </div>
</div>