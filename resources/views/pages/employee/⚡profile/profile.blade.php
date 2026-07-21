{{-- resources/views/livewire/employee/profile-info.blade.php --}}

<div>
    <div class="w-full">
        <!-- Profile Header with Cover Photo -->
        <div class="relative w-full bg-white overflow-hidden lg:rounded-2xl">
            <div class="relative w-full h-40 sm:h-48 md:h-56 lg:h-64 bg-gradient-to-r from-[#1E7A4A] to-emerald-500">
                @if ($this->coverPhoto)
                    <img src="{{ Storage::url($this->coverPhoto) }}" 
                         alt="Cover Photo"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-r from-[#1E7A4A] to-emerald-500">
                        <svg class="w-16 h-16 sm:w-20 sm:h-20 text-white/20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                        </svg>
                    </div>
                @endif

                <!-- 3-Dots Menu -->
                <div class="absolute top-3 right-3" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" 
                            class="p-1.5 bg-black/30 hover:bg-black/50 text-white rounded-lg transition backdrop-blur-sm">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="5" r="1.5" />
                            <circle cx="12" cy="12" r="1.5" />
                            <circle cx="12" cy="19" r="1.5" />
                        </svg>
                    </button>

                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-1 w-44 bg-white rounded-xl shadow-lg border border-gray-200 py-1 z-50">
                        
                        <label class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 cursor-pointer transition">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                            </svg>
                            Upload Cover
                            <input type="file" 
                                   wire:model="newCoverPhoto" 
                                   accept="image/*" 
                                   class="hidden"
                                   @change="open = false">
                        </label>

                        @if($this->coverPhoto)
                            <div class="border-t border-gray-100 my-0.5"></div>
                            <button wire:click="removeCoverPhoto" 
                                    @click="open = false"
                                    class="flex items-center gap-2.5 px-4 py-2 text-sm text-red-600 hover:bg-red-50 w-full transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                </svg>
                                Remove Cover
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Loading Spinner -->
                <div wire:loading wire:target="newCoverPhoto" 
                     class="absolute inset-0 bg-black/50 flex items-center justify-center">
                    <svg class="animate-spin h-10 w-10 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>

            <!-- Profile Info -->
            <div class="mx-auto px-4 sm:px-6 lg:px-8">
                <div class="relative -mt-12 sm:-mt-14 md:-mt-16 pb-4 sm:pb-5">
                    
                    <!-- Avatar & Name Row -->
                    <div class="flex flex-col sm:flex-row sm:items-end gap-4 sm:gap-6">
                        <!-- Avatar -->
                        <div class="relative shrink-0">
                            @if ($this->avatar)
                                <img src="{{ Storage::url($this->avatar) }}" 
                                     alt="{{ $user->name }}"
                                     class="w-24 h-24 sm:w-28 sm:h-28 md:w-32 md:h-32 rounded-full border-4 border-white object-cover shadow-xl">
                            @else
                                <div class="w-24 h-24 sm:w-28 sm:h-28 md:w-32 md:h-32 rounded-full border-4 border-white bg-emerald-100 flex items-center justify-center shadow-xl">
                                    <span class="text-3xl sm:text-4xl md:text-5xl font-bold text-[#1E7A4A]">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </span>
                                </div>
                            @endif
                            <a href="{{ route('employee.update_profile') }}" 
                               class="absolute bottom-1 right-1 bg-white rounded-full p-1.5 sm:p-2 shadow-md hover:bg-gray-50 transition border border-gray-200">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-[#111827]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </a>
                        </div>

                        <!-- Name & Status -->
                        <div class="flex-1 min-w-0 mt-2 sm:mt-3 md:mt-4">
                            <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-medium bg-emerald-100 text-emerald-700 rounded-full">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                    Active
                                </span>
                            </div>
                            <p class="text-sm sm:text-base text-gray-600 mt-0.5">{{ $user->email }}</p>
                        </div>

                        <!-- Edit Button -->
                        <a href="{{ route('employee.update_profile') }}" 
                           class="inline-flex items-center gap-2 px-4 sm:px-6 py-2 sm:py-2.5 bg-[#1E7A4A] text-white rounded-xl hover:bg-[#16653D] transition text-sm font-medium shadow-sm hover:shadow-md shrink-0 self-start sm:self-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                            Edit Profile
                        </a>
                    </div>

                    <!-- Bio - Under Avatar -->
                    <div class="mt-4 sm:mt-5">
                        <div class="bg-gray-50 rounded-xl px-4 sm:px-5 py-3 sm:py-4 border border-gray-100">
                            <div class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/>
                                </svg>
                                <div>
                                    @if ($user->bio)
                                        <p class="text-sm sm:text-base text-gray-700 leading-relaxed">{{ $user->bio }}</p>
                                    @else
                                        <p class="text-sm sm:text-base text-gray-400 italic">No bio added yet</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 border-t border-gray-100">
            <div class="mx-auto py-2">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-2">
                    <!-- Personal Information -->
                    <div class="lg:col-span-2">
                        <div class="bg-white lg:rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-5 sm:px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                                <div class="flex items-center gap-2.5">
                                    <svg class="w-5 h-5 text-[#1E7A4A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Personal Information</h2>
                                </div>
                            </div>
                            <div class="p-5 sm:p-6">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 sm:gap-6">
                                    <div class="space-y-1">
                                        <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider">Full Name</label>
                                        <p class="text-sm sm:text-base text-gray-900 font-medium">{{ $user->name }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider">Email</label>
                                        <p class="text-sm sm:text-base text-gray-900">{{ $user->email }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider">Phone</label>
                                        <p class="text-sm sm:text-base text-gray-900">{{ $user->phone ?? 'Not provided' }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider">Location</label>
                                        <p class="text-sm sm:text-base text-gray-900">{{ $user->address ?? 'Not provided' }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider">Member Since</label>
                                        <p class="text-sm sm:text-base text-gray-900">{{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider">Status</label>
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-medium bg-emerald-100 text-emerald-700 rounded-full">
                                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-1">
                        <!-- Employment Card -->
                        <div class="bg-white lg:rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-5 sm:px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                                <div class="flex items-center gap-2.5">
                                    <svg class="w-5 h-5 text-[#1E7A4A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Employment</h2>
                                </div>
                            </div>
                            <div class="p-5 sm:p-6">
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider">Position</label>
                                        <p class="text-sm text-gray-900 font-medium">{{ $employeeData?->position ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider">Hired Date</label>
                                        <p class="text-sm text-gray-900">{{ $employeeData?->hired_at?->format('M d, Y') ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider">Commission Rate</label>
                                        <p class="text-sm text-gray-900">{{ $employeeData?->commission_rate ?? 0 }}%</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider">Commission Eligible</label>
                                        <p class="text-sm text-gray-900">{{ $employeeData?->is_commission_eligible ? '✅ Yes' : '❌ No' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-2">
                    <div class="bg-white lg:rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-5 sm:px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                            <div class="flex items-center gap-2.5">
                                <svg class="w-5 h-5 text-[#1E7A4A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Your Permissions</h2>
                            </div>
                        </div>
                        <div class="p-5 sm:p-6">
                            @if($user->permissions->count() > 0)
                                <div class="flex flex-wrap gap-2.5">
                                    @foreach($user->permissions as $permission)
                                        <span class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium bg-[#1E7A4A]/10 text-[#1E7A4A] rounded-lg border border-[#1E7A4A]/20 hover:bg-[#1E7A4A]/20 transition">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-6">
                                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    <p class="text-sm text-gray-400">No permissions assigned yet</p>
                                    <p class="text-xs text-gray-400 mt-1">Contact your shop owner to grant you access</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Bottom Spacing for Browser Visibility -->
                <div class="h-8 sm:h-12"></div>
            </div>
        </div>
    </div>
</div>