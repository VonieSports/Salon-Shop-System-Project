
<div>
   <div class="w-full">
    <div class="">
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-200">
            <div class="bg-[#1E7A4A] px-6 py-5">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h1 class="text-xl sm:text-2xl font-semibold text-white">Edit Profile</h1>
                        <p class="text-white/80 text-sm mt-0.5">Update your personal information</p>
                    </div>

                    <a href="{{ route('customer.profile') }}" 
                       class="text-white/80 hover:text-white transition flex items-center gap-1.5 text-sm font-medium self-start sm:self-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back 
                    </a>
                </div>
            </div>

            <div class="p-6">
                @if (session()->has('success'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <form wire:submit="updateProfile" enctype="multipart/form-data">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Main Form -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Personal Info -->
                            <div>
                                <h2 class="text-sm font-semibold text-[#1E7A4A] uppercase tracking-wider mb-4">Personal Information</h2>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                                        <input type="text" wire:model="user_name" 
                                               placeholder="John Doe"
                                               class="w-full rounded-lg border border-gray-300 bg-white focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-3 sm:px-4 py-2 sm:py-2.5 text-sm">
                                        @error('user_name') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                                        <input type="email" wire:model="user_email" 
                                               placeholder="john@example.com"
                                               class="w-full rounded-lg border border-gray-300 bg-white focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-3 sm:px-4 py-2 sm:py-2.5 text-sm">
                                        @error('user_email') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Phone</label>
                                        <input type="text" wire:model="user_phone" 
                                               placeholder="(555) 000-0000"
                                               class="w-full rounded-lg border border-gray-300 bg-white focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-3 sm:px-4 py-2 sm:py-2.5 text-sm">
                                        @error('user_phone') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Location</label>
                                        <input type="text" wire:model="user_address" 
                                               placeholder="New York, USA"
                                               class="w-full rounded-lg border border-gray-300 bg-white focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-3 sm:px-4 py-2 sm:py-2.5 text-sm">
                                        @error('user_address') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Bio -->
                            <div>
                                <h2 class="text-sm font-semibold text-[#1E7A4A] uppercase tracking-wider mb-3">Bio</h2>
                                <textarea wire:model="user_bio" rows="4" 
                                          class="w-full rounded-lg border border-gray-300 bg-white focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-3 sm:px-4 py-2 sm:py-2.5 text-sm"
                                          placeholder="Tell us a bit about yourself..."></textarea>
                                @error('user_bio') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                <div class="flex justify-end mt-1.5">
                                    <span class="text-sm text-gray-400">{{ strlen($user_bio ?? '') }}/500</span>
                                </div>
                            </div>

                            <!-- Customer Details -->
                            @if ($customer)
                                <div>
                                    <h2 class="text-sm font-semibold text-[#1E7A4A] uppercase tracking-wider mb-4">Additional Details</h2>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Gender</label>
                                            <select wire:model="customer_gender"
                                                    class="w-full rounded-lg border border-gray-300 bg-white focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-3 py-2 text-sm">
                                                <option value="">Select gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                            </select>
                                            @error('customer_gender') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Member Since</label>
                                            <p class="text-gray-600 text-sm py-2">{{ $user->created_at->format('F d, Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Password Change -->
                            <div class="border-t border-gray-200 pt-6">
                                <h2 class="text-sm font-semibold text-[#1E7A4A] uppercase tracking-wider mb-4">Change Password</h2>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
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
                                    <div class="sm:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Confirm New Password</label>
                                        <input type="password" wire:model="new_password_confirmation" 
                                               placeholder="Confirm new password"
                                               class="w-full rounded-lg border border-gray-300 bg-white focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-3 sm:px-4 py-2 sm:py-2.5 text-sm">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="lg:col-span-1 space-y-6">
                            <!-- Upload Photo Card -->
                            <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                                <h2 class="text-sm font-semibold text-[#1E7A4A] uppercase tracking-wider mb-3">Profile Photo</h2>
                                
                                <div class="flex flex-col items-center">
                                    <div class="relative mb-3">
                                        @if ($avatar)
                                            <img src="{{ $avatar->temporaryUrl() }}" 
                                                 class="w-24 h-24 rounded-full object-cover border-4 border-[#1E7A4A] shadow-lg">
                                        @elseif ($user->avatar)
                                            <img src="{{ Storage::url($user->avatar) }}" 
                                                 class="w-24 h-24 rounded-full object-cover border-4 border-gray-200 shadow-lg">
                                        @else
                                            <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center border-4 border-gray-200 shadow-lg">
                                                <span class="text-3xl font-semibold text-gray-500">
                                                    {{ strtoupper(substr($user->name ?? 'U', 0, 2)) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <label class="cursor-pointer w-full text-center px-4 py-2.5 bg-[#1E7A4A] text-white rounded-lg hover:bg-[#16653D] transition text-sm font-medium">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                        </svg>
                                        Choose Photo
                                        <input type="file" wire:model="avatar" accept="image/*" class="hidden">
                                    </label>
                                    
                                    <p class="text-xs text-gray-400 mt-2 text-center">At least 800×800 px recommended.<br>JPG or PNG is allowed.</p>
                                    
                                    @error('avatar') <span class="text-red-500 text-sm mt-1 block text-center">{{ $message }}</span> @enderror
                                    @if ($avatar)
                                        <p class="text-sm text-green-600 mt-2 text-center font-medium">✓ {{ $avatar->getClientOriginalName() }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:items-center gap-3 mt-6 pt-5 border-t border-gray-200">
                        <a href="{{ route('customer.profile') }}" 
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
</div>