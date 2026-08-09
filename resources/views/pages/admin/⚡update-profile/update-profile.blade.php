
<div>
    <div class="mx-auto space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.profile') }}" wire:navigate class="p-2 rounded-lg hover:bg-gray-100 transition">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Profile</h1>
            <p class="text-sm text-gray-500 mt-0.5">Update your admin account details</p>
        </div>
    </div>

    <form wire:submit.prevent="updateProfile" enctype="multipart/form-data" class="space-y-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center gap-5">
                <label class="group relative block w-20 h-20 rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50 overflow-hidden cursor-pointer hover:border-emerald-400 transition shrink-0">
                    @if ($avatar)
                        <img src="{{ $avatar->temporaryUrl() }}" class="absolute inset-0 w-full h-full object-cover">
                    @elseif ($existingAvatar)
                        <img src="{{ Storage::url($existingAvatar) }}" class="absolute inset-0 w-full h-full object-cover">
                    @else
                        <div class="absolute inset-0 flex items-center justify-center text-gray-400">
                            <span class="text-xl font-bold">{{ strtoupper(substr($name ?: 'A', 0, 1)) }}</span>
                        </div>
                    @endif
                    <input type="file" wire:model="avatar" accept="image/*" class="hidden">
                </label>
                <div>
                    <p class="text-sm font-medium text-gray-700">Click the photo to change it</p>
                    <p class="text-xs text-gray-400 mt-0.5">JPG or PNG, max 2MB</p>
                    @error('avatar') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
            <h3 class="text-sm font-bold text-gray-800">Personal Information</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Full Name</label>
                    <input type="text" wire:model.blur="name"
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400 focus:bg-white transition text-sm">
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Email</label>
                    <input type="email" wire:model.blur="email"
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400 focus:bg-white transition text-sm">
                    @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Phone</label>
                    <input type="text" wire:model.blur="phone"
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400 focus:bg-white transition text-sm">
                    @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Address</label>
                    <input type="text" wire:model.blur="address"
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400 focus:bg-white transition text-sm">
                    @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1.5">Bio</label>
                <textarea wire:model.blur="bio" rows="3"
                          class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400 focus:bg-white transition text-sm resize-none"></textarea>
                @error('bio') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="text-sm font-bold text-gray-800">Reset Password</h3>
            <p class="text-xs text-gray-400 mt-0.5 mb-4">Leave blank to keep your current password</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">New Password</label>
                    <input type="password" wire:model.blur="newPassword" placeholder="Min. 8 characters"
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400 focus:bg-white transition text-sm">
                    @error('newPassword') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Confirm New Password</label>
                    <input type="password" wire:model.blur="newPasswordConfirmation"
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400 focus:bg-white transition text-sm">
                    @error('newPasswordConfirmation') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.profile') }}" wire:navigate
               class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition text-sm font-medium">
                Cancel
            </a>
            <button type="submit" wire:loading.attr="disabled" wire:target="updateProfile"
                    class="inline-flex items-center justify-center gap-2 px-8 py-2.5 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition text-sm font-medium shadow-sm disabled:opacity-60">
                <span wire:loading.remove wire:target="updateProfile">Save Changes</span>
                <span wire:loading wire:target="updateProfile">Saving...</span>
            </button>
        </div>
    </form>
</div>
    {{-- The whole future lies in uncertainty: live immediately. - Seneca --}}
</div>