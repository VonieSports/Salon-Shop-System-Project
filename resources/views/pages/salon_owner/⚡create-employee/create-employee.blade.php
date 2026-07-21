{{-- resources/views/livewire/owner/create-employee.blade.php --}}

<div class="min-h-screen bg-gray-50">
    <div class="w-full">
        <div class="px-3 sm:px-6 py-2 sm:py-3 bg-white border-b border-gray-100 sm:hidden">
            <a href="{{ route('owner.employee') }}"
               class="inline-flex items-center gap-1.5 text-neutral-600 hover:text-neutral-900 transition text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Employees
            </a>
        </div>
      
        <div class="bg-white shadow-sm border-x-0 sm:border-x border-gray-200 overflow-hidden rounded-2xl">
            <div class="px-3 sm:px-6 py-3 sm:py-5 border-b border-gray-100 bg-[#1E7A4A]">
                <div>
                    <h1 class="text-lg sm:text-2xl font-bold text-white">Add Employee</h1>
                    <p class="text-white/80 text-xs sm:text-sm mt-0.5">Create a new employee account</p>
                </div>
            </div>

            <div class="px-3 sm:px-6 py-4 sm:py-6">
                @if (session()->has('error'))
                <div class="mb-4 p-3 sm:p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                    {{ session('error') }}
                </div>
                @endif

                <form wire:submit.prevent="save" enctype="multipart/form-data">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <!-- Profile Picture -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Profile Picture</label>
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        <div class="w-20 h-20 rounded-full overflow-hidden border-4 border-emerald-500 bg-gray-50 shadow-md">
                                            @if($avatar)
                                                <img src="{{ $avatar->temporaryUrl() }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center bg-gray-50">
                                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <label for="avatar-upload" class="absolute bottom-0 right-0 p-1.5 bg-[#1E7A4A] rounded-full cursor-pointer hover:bg-[#16633c] transition shadow-lg">
                                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                                            </svg>
                                        </label>
                                        <input type="file" id="avatar-upload" wire:model="avatar" accept="image/*" class="hidden">
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400">JPG, PNG. Max 2MB</p>
                                        @if($avatar)
                                            <button type="button" wire:click="$set('avatar', null)" class="mt-1 text-xs text-red-500 hover:text-red-700 font-medium">
                                                Remove Photo
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                @error('avatar')
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="name" placeholder="Enter the full name"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition">
                                @error('name') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                                <input type="email" wire:model="email" placeholder="john@example.com"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition">
                                @error('email') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Phone</label>
                                <input type="text" wire:model="phone" placeholder="09123456789"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition">
                                @error('phone') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <!-- Position -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Position <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="position" placeholder="Senior Stylist"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition">
                                @error('position') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Address -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Address</label>
                                <input type="text" wire:model="address" placeholder="123 Main St"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition">
                                @error('address') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Password <span class="text-red-500">*</span></label>
                                <input type="password" wire:model="password" placeholder="Enter password"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition">
                                <p class="text-xs text-gray-400 mt-1">Minimum 8 characters</p>
                                @error('password') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Confirm Password <span class="text-red-500">*</span></label>
                                <input type="password" wire:model="password_confirmation" placeholder="Confirm password"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition">
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 mt-6 pt-6 border-t border-gray-200">
                        <a href="{{ route('owner.employee') }}"
                            class="w-full sm:w-auto px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm font-medium text-center">
                            Cancel
                        </a>
                        <button type="submit"
                            class="w-full sm:w-auto px-8 py-2.5 bg-[#1E7A4A] text-white rounded-lg hover:bg-[#16633c] transition text-sm font-medium shadow-sm hover:shadow"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove>Create Employee</span>
                            <span wire:loading>
                                <svg class="animate-spin h-4 w-4 inline mr-2" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Creating...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>