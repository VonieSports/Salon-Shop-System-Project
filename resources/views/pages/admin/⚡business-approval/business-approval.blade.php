<div class="space-y-6">
    @if (session()->has('message'))
        <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-5 py-3.5 rounded-xl text-sm font-medium flex items-center gap-2">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('message') }}
        </div>
    @endif

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pending Approvals</h1>
            <p class="text-sm text-gray-500 mt-1">Review submitted businesses and decide whether to approve or reject them</p>
        </div>
        <div class="inline-flex items-center gap-2.5 px-4 py-2.5 bg-amber-50 border border-amber-100 rounded-xl">
            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
            <span class="text-sm font-semibold text-amber-700">{{ $this->pendingCount }} awaiting review</span>
        </div>
    </div>

    <!-- List -->
    <div class="space-y-4">
        @forelse ($this->pendingTenants as $tenant)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                <div class="p-5 sm:p-6 flex flex-col lg:flex-row lg:items-center gap-5">

                    <!-- Logo + identity -->
                    <div class="flex items-center gap-4 lg:w-72 shrink-0">
                        <div class="w-16 h-16 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center shrink-0 overflow-hidden">
                            @if ($tenant->logo)
                                <img src="{{ Storage::url($tenant->logo) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-xl font-bold text-emerald-600">{{ strtoupper(substr($tenant->name, 0, 1)) }}</span>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <p class="font-bold text-gray-900 truncate">{{ $tenant->name }}</p>
                            </div>
                            @if ($tenant->isBranch())
                                <span class="inline-block mt-1 text-[11px] px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 font-medium">
                                    Branch of {{ $tenant->parentTenant?->name }}
                                </span>
                            @else
                                <span class="inline-block mt-1 text-[11px] px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 font-medium">
                                    Headquarters
                                </span>
                            @endif
                            <p class="text-xs text-gray-400 mt-1.5">Submitted {{ $tenant->submitted_at?->diffForHumans() }}</p>
                        </div>
                    </div>

                    <!-- Details grid -->
                    <div class="flex-1 grid grid-cols-1 sm:grid-cols-3 gap-4 py-1 lg:border-x lg:border-gray-100 lg:px-6">
                        <div>
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Owner</p>
                            <p class="text-sm text-gray-800 font-medium">{{ $tenant->owner?->name ?? '—' }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ $tenant->owner?->email }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Contact</p>
                            <p class="text-sm text-gray-800">{{ $tenant->email }}</p>
                            <p class="text-xs text-gray-400">{{ $tenant->phone }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Type & Address</p>
                            <p class="text-sm text-gray-800">{{ $tenant->business_type ?: '—' }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ $tenant->address }}</p>
                        </div>
                    </div>

                    @if ($tenant->description)
                        <div class="hidden xl:block max-w-[220px]">
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Description</p>
                            <p class="text-xs text-gray-500 line-clamp-3">{{ $tenant->description }}</p>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex sm:flex-col gap-2 lg:w-36 shrink-0">
                        <button wire:click="approve({{ $tenant->id }})"
                                wire:confirm="Approve '{{ $tenant->name }}'?"
                                class="flex-1 inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition text-sm font-semibold shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Approve
                        </button>
                        <button wire:click="openRejectModal({{ $tenant->id }})"
                                class="flex-1 inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-white border border-red-200 text-red-600 rounded-xl hover:bg-red-50 transition text-sm font-semibold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Reject
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-16 text-center">
                <div class="mx-auto w-16 h-16 rounded-full bg-emerald-50 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-gray-700 font-semibold">All caught up</p>
                <p class="text-sm text-gray-400 mt-1">There are no pending submissions right now.</p>
            </div>
        @endforelse
    </div>

    @if ($this->pendingTenants->hasPages())
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-6 py-4">
            {{ $this->pendingTenants->links() }}
        </div>
    @endif

    <!-- Reject Modal -->
    @if ($showRejectModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" wire:click="closeRejectModal"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Reject Submission</h3>
                </div>

                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Reason for rejection</label>
                <textarea wire:model="rejectionReason" rows="4" placeholder="Explain what needs to be fixed so the owner can resubmit correctly..."
                          class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-200 focus:border-red-300 focus:bg-white transition text-sm"></textarea>
                @error('rejectionReason') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror

                <div class="mt-5 flex gap-3">
                    <button wire:click="closeRejectModal" class="flex-1 px-4 py-2.5 border border-gray-300 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">Cancel</button>
                    <button wire:click="reject" class="flex-1 px-4 py-2.5 bg-red-600 text-white rounded-xl text-sm font-semibold hover:bg-red-700 transition">Confirm Reject</button>
                </div>
            </div>
        </div>
    @endif
</div>