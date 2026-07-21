<div>
    <div class="w-full">
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-200">
            <!-- Header -->
            <div class="bg-[#1E7A4A] px-4 sm:px-6 py-4 sm:py-5">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h1 class="text-xl sm:text-2xl font-semibold text-white">Edit Profile</h1>
                        <p class="text-white/80 text-xs sm:text-sm mt-0.5">Update your personal information and profile photo</p>
                    </div>
                    <a href="{{ route('employee.profile') }}" 
                       class="text-white/80 hover:text-white transition flex items-center gap-1.5 text-sm font-medium self-start sm:self-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Profile
                    </a>
                </div>
            </div>

            <div class="p-4 sm:p-6">
                @if (session()->has('success'))
                    <div class="mb-4 sm:mb-5 p-3 sm:p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <form wire:submit="updateProfile" enctype="multipart/form-data">
                    <!-- Profile Preview Section - Same as Profile View -->
                    <div class="mb-8 bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
                        <!-- Cover Photo -->
                        <div class="relative h-40 sm:h-48 md:h-56 bg-gradient-to-r from-[#1E7A4A] to-emerald-400">
                            @if($cover_photo)
                                <img src="{{ Storage::url($cover_photo) }}" class="w-full h-full object-cover">
                            @elseif($newCoverPhoto)
                                <img src="{{ $newCoverPhoto->temporaryUrl() }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-r from-[#1E7A4A] to-emerald-500">
                                    <svg class="w-12 h-12 sm:w-16 sm:h-16 text-white/20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                    </svg>
                                </div>
                            @endif

                            <!-- Cover Photo Upload Button -->
                            <div class="absolute bottom-4 right-4 flex gap-2">
                                <label for="cover-photo-upload" class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 bg-black/50 hover:bg-black/70 text-white rounded-lg text-sm font-medium transition backdrop-blur-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                                    </svg>
                                    <span class="hidden sm:inline">Change Cover</span>
                                    <span class="sm:hidden">Cover</span>
                                </label>
                                <input id="cover-photo-upload" type="file" wire:model="newCoverPhoto" accept="image/*" class="hidden">

                                @if($cover_photo)
                                    <button type="button" wire:click="removeCoverPhoto" class="inline-flex items-center gap-2 px-4 py-2 bg-red-500/80 hover:bg-red-600 text-white rounded-lg text-sm font-medium transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                        </svg>
                                        <span class="hidden sm:inline">Remove</span>
                                    </button>
                                @endif
                            </div>

                            @error('newCoverPhoto')
                                <span class="text-red-500 text-xs mt-1 block absolute bottom-16 right-4 bg-white/90 px-2 py-1 rounded shadow">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Profile Info Overlay -->
                        <div class="relative px-4 sm:px-6 pb-6">
                            <div class="flex flex-col sm:flex-row items-center sm:items-end -mt-12 sm:-mt-16 mb-4">
                                <!-- Avatar -->
                                <div class="relative">
                                    <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-full overflow-hidden border-4 border-white bg-gray-100 shadow-lg">
                                        @if($newAvatar)
                                            <img src="{{ $newAvatar->temporaryUrl() }}" class="w-full h-full object-cover">
                                        @elseif($avatar)
                                            <img src="{{ Storage::url($avatar) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-emerald-100">
                                                <span class="text-3xl sm:text-4xl font-bold text-[#1E7A4A]">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Avatar Upload Button -->
                                    <label for="avatar-upload" class="absolute bottom-0 right-0 p-1.5 bg-[#1E7A4A] rounded-full cursor-pointer hover:bg-[#16633c] transition shadow-lg">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                                        </svg>
                                    </label>
                                    <input id="avatar-upload" type="file" wire:model="newAvatar" accept="image/*" class="hidden">
                                    
                                    @error('newAvatar')
                                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Name & Status -->
                                <div class="sm:ml-6 mt-4 sm:mt-0 text-center sm:text-left flex-1">
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                                        <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                                        <span class="px-3 py-1 text-xs rounded-full {{ $status['badge_class'] ?? 'bg-gray-100 text-gray-500' }}">
                                            {{ $status['label'] ?? 'Offline' }}
                                        </span>
                                    </div>
                                    <p class="text-gray-500">{{ $employeeData?->position ?? 'Employee' }}</p>
                                </div>
                            </div>

                            <!-- Bio -->
                            <div class="mt-2 px-4 py-3 bg-gray-50 rounded-lg border border-gray-100">
                                <div class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/>
                                    </svg>
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-700">{{ $bio ?? $user->bio ?? 'No bio added yet' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Form -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Personal Information -->
                            <div>
                                <h2 class="text-sm font-semibold text-[#111827] uppercase tracking-wider mb-4">Personal Information</h2>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                                        <input type="text" wire:model="name" 
                                               class="w-full rounded-lg border border-gray-300 bg-white focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-3 sm:px-4 py-2 sm:py-2.5 text-sm">
                                        @error('name') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                                        <input type="email" wire:model="email" 
                                               class="w-full rounded-lg border border-gray-300 bg-white focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-3 sm:px-4 py-2 sm:py-2.5 text-sm">
                                        @error('email') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Phone</label>
                                        <input type="text" wire:model="phone" 
                                               class="w-full rounded-lg border border-gray-300 bg-white focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-3 sm:px-4 py-2 sm:py-2.5 text-sm">
                                        @error('phone') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Location</label>
                                        <input type="text" wire:model="address" 
                                               class="w-full rounded-lg border border-gray-300 bg-white focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-3 sm:px-4 py-2 sm:py-2.5 text-sm">
                                        @error('address') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Bio Edit -->
                            <div>
                                <h2 class="text-sm font-semibold text-[#111827] uppercase tracking-wider mb-4">Bio</h2>
                                <textarea wire:model="bio" rows="4" 
                                          class="w-full rounded-lg border border-gray-300 bg-white focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-3 sm:px-4 py-2 sm:py-2.5 text-sm"
                                          placeholder="Describe yourself..."></textarea>
                                @error('bio') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                <div class="flex justify-end mt-1.5">
                                    <span class="text-sm text-gray-400">{{ strlen($bio ?? '') }}/500</span>
                                </div>
                            </div>

                            <!-- Change Password -->
                            <div>
                                <h2 class="text-sm font-semibold text-[#111827] uppercase tracking-wider mb-4">Change Password</h2>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Current Password</label>
                                        <input type="password" wire:model="current_password" 
                                               placeholder="Enter current password"
                                               class="w-full rounded-lg border border-gray-300 bg-white focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-3 sm:px-4 py-2 sm:py-2.5 text-sm">
                                        @error('current_password') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">New Password</label>
                                        <input type="password" wire:model="new_password" 
                                               placeholder="Enter new password"
                                               class="w-full rounded-lg border border-gray-300 bg-white focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-3 sm:px-4 py-2 sm:py-2.5 text-sm">
                                        @error('new_password') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Confirm New Password</label>
                                        <input type="password" wire:model="new_password_confirmation" 
                                               placeholder="Confirm new password"
                                               class="w-full rounded-lg border border-gray-300 bg-white focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-3 sm:px-4 py-2 sm:py-2.5 text-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:items-center gap-3 mt-8 pt-5 border-t border-gray-200">
                        <a href="{{ route('employee.profile') }}" 
                           class="w-full sm:w-auto text-center px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm font-medium">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="w-full sm:w-auto px-8 py-2.5 bg-[#1E7A4A] text-white rounded-lg hover:bg-[#16653D] transition text-sm font-medium shadow-sm hover:shadow-md"
                                wire:loading.attr="disabled">
                            <span wire:loading.remove>Save Changes</span>
                            <span wire:loading>Saving...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>