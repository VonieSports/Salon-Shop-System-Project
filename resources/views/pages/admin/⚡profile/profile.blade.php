<div class=" mx-auto space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">My Profile</h1>
        <p class="text-sm text-gray-500 mt-1">Your administrator account details</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="h-28 bg-gradient-to-r from-emerald-600 to-emerald-400"></div>

        <div class="px-6 pb-6">
            <div class="flex items-end justify-between -mt-12 mb-4">
                <div class="w-24 h-24 rounded-2xl bg-white p-1 shadow-lg">
                    <div class="w-full h-full rounded-xl bg-emerald-100 flex items-center justify-center overflow-hidden">
                        @if ($admin->avatar)
                            <img src="{{ Storage::url($admin->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-2xl font-bold text-emerald-700">{{ strtoupper(substr($admin->name, 0, 1)) }}</span>
                        @endif
                    </div>
                </div>
                <a href="{{ route('admin.update_profile') }}" wire:navigate
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Edit Profile
                </a>
            </div>

            <h2 class="text-xl font-bold text-gray-900">{{ $admin->name }}</h2>
            <span class="inline-flex items-center gap-1.5 mt-1 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                Administrator
            </span>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mt-6 pt-6 border-t border-gray-100">
                <div>
                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Email</p>
                    <p class="text-sm text-gray-800">{{ $admin->email }}</p>
                </div>
                <div>
                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Phone</p>
                    <p class="text-sm text-gray-800">{{ $admin->phone ?: 'Not provided' }}</p>
                </div>
                <div>
                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Address</p>
                    <p class="text-sm text-gray-800">{{ $admin->address ?: 'Not provided' }}</p>
                </div>
                <div>
                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide mb-1">Member Since</p>
                    <p class="text-sm text-gray-800">{{ $admin->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            @if ($admin->bio)
                <div class="mt-5 pt-5 border-t border-gray-100">
                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Bio</p>
                    <p class="text-sm text-gray-700 leading-relaxed">{{ $admin->bio }}</p>
                </div>
            @endif
        </div>
    </div>
</div>