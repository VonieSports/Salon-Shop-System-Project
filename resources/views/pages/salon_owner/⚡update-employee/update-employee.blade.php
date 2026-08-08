<div>
  <div class="min-h-screen bg-gray-50">
    <div class="mx-auto space-y-6 py-6 px-4">

        @if (session()->has('message'))
            <div class="bg-green-50 text-green-700 px-5 py-3.5 rounded-xl text-sm font-medium">{{ session('message') }}</div>
        @endif
        @if (session()->has('error'))
            <div class="bg-red-50 text-red-700 px-5 py-3.5 rounded-xl text-sm font-medium">{{ session('error') }}</div>
        @endif

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 bg-[#1E7A4A] flex items-center gap-3">
                <a href="{{ route('owner.employee') }}" class="p-2 hover:bg-green-600/30 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-white">Update Employee</h1>
                    <p class="text-sm text-white/80 mt-0.5">Edit credentials, profile, and employment details</p>
                </div>
            </div>
        </div>

        @if ($employee)
        <form wire:submit.prevent="updateEmployee" enctype="multipart/form-data" class="space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-base font-bold text-gray-900">Profile Photo</h3>
                </div>
                <div class="p-6 flex items-center gap-5">
                    <label class="group relative block w-20 h-20 rounded-full border-2 border-dashed border-gray-300 bg-gray-50 overflow-hidden cursor-pointer hover:border-[#1E7A4A] transition shrink-0">
                        @if($avatar)
                            <img src="{{ $avatar->temporaryUrl() }}" class="absolute inset-0 w-full h-full object-cover">
                        @elseif($existingAvatar)
                            <img src="{{ Storage::url($existingAvatar) }}" class="absolute inset-0 w-full h-full object-cover">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center text-gray-400 group-hover:text-[#1E7A4A] transition">
                                <span class="text-xl font-bold">{{ strtoupper(substr($name ?: 'U', 0, 1)) }}</span>
                            </div>
                        @endif
                        <input type="file" wire:model="avatar" accept="image/*" class="hidden">
                    </label>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Click the photo to change it</p>
                        <p class="text-xs text-gray-400 mt-0.5">JPG or PNG, max 2MB</p>
                        @error('avatar') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        <div wire:loading wire:target="avatar" class="mt-1 text-xs text-emerald-600 font-medium">Uploading...</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-base font-bold text-gray-900">Personal Information</h3>
                </div>
                <div class="p-6 space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">Full Name</label>
                            <input type="text" wire:model.blur="name"
                                   class="w-full px-4 py-3 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm text-gray-900">
                            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">Email</label>
                            <input type="email" wire:model.blur="email"
                                   class="w-full px-4 py-3 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm text-gray-900">
                            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">Phone</label>
                            <input type="text" wire:model.blur="phone"
                                   class="w-full px-4 py-3 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm text-gray-900">
                            @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">Address</label>
                            <input type="text" wire:model.blur="address"
                                   class="w-full px-4 py-3 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm text-gray-900">
                            @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Bio</label>
                        <textarea wire:model.blur="bio" rows="3"
                                  class="w-full px-4 py-3 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm text-gray-900 resize-none"></textarea>
                        @error('bio') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-base font-bold text-gray-900">Reset Password</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Leave blank to keep the current password</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">New Password</label>
                            <input type="password" wire:model.blur="newPassword" placeholder="Min. 8 characters"
                                   class="w-full px-4 py-3 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm text-gray-900">
                            @error('newPassword') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">Confirm New Password</label>
                            <input type="password" wire:model.blur="newPasswordConfirmation"
                                   class="w-full px-4 py-3 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm text-gray-900">
                            @error('newPasswordConfirmation') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-base font-bold text-gray-900">Employment Details</h3>
                </div>
                <div class="p-6 space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">Position</label>
                            <input type="text" wire:model.blur="position"
                                   class="w-full px-4 py-3 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm text-gray-900">
                            @error('position') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">Hired Date</label>
                            <input type="date" wire:model.blur="hiredAt"
                                   class="w-full px-4 py-3 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm text-gray-900">
                            @error('hiredAt') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-end">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">Commission Rate (%)</label>
                            <input type="number" step="0.01" min="0" max="100" wire:model.blur="commissionRate"
                                   class="w-full px-4 py-3 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm text-gray-900">
                            @error('commissionRate') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="flex items-center gap-2 pb-3">
                            <input type="checkbox" id="isCommissionEligible" wire:model="isCommissionEligible"
                                   class="w-4 h-4 rounded text-[#1E7A4A] focus:ring-[#1E7A4A]">
                            <label for="isCommissionEligible" class="text-sm text-gray-700">Eligible for commission</label>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="isActive" wire:model="isActive"
                               class="w-4 h-4 rounded text-[#1E7A4A] focus:ring-[#1E7A4A]">
                        <label for="isActive" class="text-sm text-gray-700">Employee is active</label>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('owner.employee') }}"
                   class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition text-sm font-medium">
                    Cancel
                </a>
                <button type="submit" wire:loading.attr="disabled" wire:target="updateEmployee"
                        class="inline-flex items-center justify-center gap-2 px-8 py-2.5 bg-[#1E7A4A] text-white rounded-xl hover:bg-[#16633c] transition text-sm font-medium shadow-sm disabled:opacity-60">
                    <span wire:loading.remove wire:target="updateEmployee">Save Changes</span>
                    <span wire:loading wire:target="updateEmployee">Saving...</span>
                </button>
            </div>
        </form>
        @endif
    </div>
  </div>
</div>