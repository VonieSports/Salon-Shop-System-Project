<div>
    <div class="w-full">
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-200">
            <div class="bg-[#1E7A4A] px-4 sm:px-6 py-4 sm:py-5">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h1 class="text-xl sm:text-2xl font-semibold text-white">Edit Profile</h1>
                        <p class="text-white/80 text-xs sm:text-sm mt-0.5">Update your personal information and profile photo</p>
                    </div>
                    <a href="{{ route('owner.profile') }}" 
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

                <form wire:submit="updateProfile">
                    <div class="mb-8 bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
                        <div class="relative h-40 sm:h-48 md:h-56 bg-gradient-to-br from-[#1E7A4A] to-emerald-400 group">
                            @if($cover_photo)
                                <img src="{{ $cover_photo->temporaryUrl() }}" class="w-full h-full object-cover">
                            @elseif($existing_cover_photo)
                                <img src="{{ Storage::url($existing_cover_photo) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#1E7A4A] to-emerald-500">
                                    <svg class="w-12 h-12 sm:w-16 sm:h-16 text-white/20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                    </svg>
                                </div>
                            @endif

                            <label class="absolute inset-0 bg-black/0 hover:bg-black/40 transition-all duration-300 cursor-pointer flex items-center justify-center">
                                <div class="opacity-0 group-hover:opacity-100 transition-all duration-300 transform scale-95 group-hover:scale-100 flex flex-col items-center gap-2">
                                    <div class="bg-white/20 backdrop-blur-sm rounded-full p-3">
                                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                                        </svg>
                                    </div>
                                    <span class="text-white text-xs sm:text-sm font-medium">
                                        {{ $existing_cover_photo ? 'Change Cover Photo' : 'Upload Cover Photo' }}
                                    </span>
                                </div>
                                <input type="file" wire:model="cover_photo" accept="image/*" class="hidden">
                            </label>

                            @if($existing_cover_photo)
                                <button type="button" 
                                        wire:click="removeCoverPhoto" 
                                        class="absolute top-3 right-3 p-1.5 bg-red-500/80 hover:bg-red-600 text-white rounded-lg transition opacity-0 group-hover:opacity-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            @endif
                        </div>

                        <div class="relative px-4 sm:px-6 pb-6">
                            <div class="flex flex-col sm:flex-row items-center sm:items-end -mt-12 sm:-mt-16 mb-4">
                                <div class="relative group">
                                    <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-full overflow-hidden border-4 border-white bg-gray-100 shadow-lg">
                                        @if($avatar)
                                            <img src="{{ $avatar->temporaryUrl() }}" class="w-full h-full object-cover">
                                        @elseif($existing_avatar)
                                            <img src="{{ Storage::url($existing_avatar) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-emerald-100">
                                                <span class="text-3xl sm:text-4xl font-bold text-[#1E7A4A]">
                                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    <label class="absolute inset-0 rounded-full bg-black/0 hover:bg-black/40 transition-all duration-300 cursor-pointer flex items-center justify-center">
                                        <div class="opacity-0 group-hover:opacity-100 transition-all duration-300">
                                            <div class="bg-white/20 backdrop-blur-sm rounded-full p-2">
                                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <input type="file" wire:model="avatar" accept="image/*" class="hidden">
                                    </label>

                                    @if($existing_avatar)
                                        <button type="button" 
                                                wire:click="removeAvatar" 
                                                class="absolute -top-1 -right-1 p-1 bg-red-500 hover:bg-red-600 text-white rounded-full transition shadow-md">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    @endif
                                </div>

                                <div class="sm:ml-6 mt-4 sm:mt-0 text-center sm:text-left flex-1">
                                    <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                                    <p class="text-gray-500">{{ $tenant?->name ?? 'Owner' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="space-y-6">
                            <h2 class="text-sm font-semibold text-[#111827] uppercase tracking-wider mb-4">Personal Information</h2>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="user_name" 
                                           class="w-full rounded-lg border border-gray-300 bg-white focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-3 sm:px-4 py-2 sm:py-2.5 text-sm">
                                    @error('user_name') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                                    <input type="email" wire:model="user_email" 
                                           class="w-full rounded-lg border border-gray-300 bg-white focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-3 sm:px-4 py-2 sm:py-2.5 text-sm">
                                    @error('user_email') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Phone</label>
                                    <input type="text" wire:model="user_phone" 
                                           class="w-full rounded-lg border border-gray-300 bg-white focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-3 sm:px-4 py-2 sm:py-2.5 text-sm">
                                    @error('user_phone') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Gender</label>
                                    <select wire:model="user_gender" class="w-full rounded-lg border border-gray-300 bg-white focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-3 sm:px-4 py-2 sm:py-2.5 text-sm">
                                        <option value="prefer_not_to_say">Prefer not to say</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                    @error('user_gender') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Birthdate</label>
                                    <input type="date" wire:model="user_birthdate" 
                                           class="w-full rounded-lg border border-gray-300 bg-white focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-3 sm:px-4 py-2 sm:py-2.5 text-sm">
                                    @error('user_birthdate') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Location</label>
                                    <input type="text" wire:model="user_address" 
                                           class="w-full rounded-lg border border-gray-300 bg-white focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-3 sm:px-4 py-2 sm:py-2.5 text-sm">
                                    @error('user_address') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <h2 class="text-sm font-semibold text-[#111827] uppercase tracking-wider mb-4">Bio</h2>
                                <textarea wire:model="user_bio" rows="4" 
                                          class="w-full rounded-lg border border-gray-300 bg-white focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-3 sm:px-4 py-2 sm:py-2.5 text-sm"
                                          placeholder="Describe yourself..."></textarea>
                                @error('user_bio') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                <div class="flex justify-end mt-1.5">
                                    <span class="text-sm text-gray-400">{{ strlen($user_bio ?? '') }}/500</span>
                                </div>
                            </div>

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
                        <a href="{{ route('owner.profile') }}" 
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
