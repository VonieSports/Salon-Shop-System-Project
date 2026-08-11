{{-- resources/views/livewire/owner/create-employee.blade.php --}}

<div class=" bg-gray-50">
    <div class="w-full">
        <div class="bg-white shadow-sm border border-gray-200 overflow-hidden lg:rounded-lg">
            
            <!-- Header -->
            <div class="px-4 sm:px-6 py-5 border-b border-gray-200 bg-[#1E7A4A]">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h1 class="text-2xl font-bold text-white">Add Employee</h1>
                        <p class="text-[#cfe8dc] text-base mt-0.5">Create a new employee account</p>
                    </div>
                    <a href="{{ route('owner.employee') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-[#1E7A4A] rounded-lg hover:bg-gray-50 transition text-base font-medium shadow-sm whitespace-nowrap">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Employees
                    </a>
                </div>
            </div>

            <!-- Form -->
            <div class="px-4 sm:px-6 py-5">
                @if (session()->has('error'))
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg text-base">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                <form wire:submit.prevent="save" enctype="multipart/form-data">
                    <!-- Profile Picture - Full Width at Top -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4 sm:gap-6">
                            <div class="relative flex-shrink-0">
                                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full overflow-hidden border-4 border-gray-200 bg-gray-50 shadow-sm">
                                    @if($avatar)
                                        <img src="{{ $avatar->temporaryUrl() }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-50">
                                            <svg class="w-10 h-10 sm:w-12 sm:h-12 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <label for="avatar-upload" class="absolute bottom-0 right-0 p-1.5 bg-[#1E7A4A] rounded-full cursor-pointer hover:bg-[#145537] transition shadow-md">
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                                    </svg>
                                </label>
                                <input type="file" id="avatar-upload" wire:model="avatar" accept="image/*" class="hidden">
                            </div>
                            <div>
                                <p class="text-base font-medium text-gray-900">Profile Picture</p>
                                <p class="text-sm text-gray-500">Upload a photo for the employee profile</p>
                                <div class="flex flex-wrap items-center gap-2 mt-1.5">
                                    <p class="text-xs text-gray-400">JPG, PNG. Max 2MB</p>
                                    @if($avatar)
                                        <span class="text-xs text-gray-300">|</span>
                                        <button type="button" wire:click="$set('avatar', null)" class="text-xs text-red-500 hover:text-red-700 font-medium transition">
                                            Remove Photo
                                        </button>
                                    @endif
                                </div>
                                @error('avatar')
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-5">
                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" wire:model="name" placeholder="Enter the full name"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-base focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition bg-white">
                                @error('name') 
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" wire:model="email" placeholder="john@example.com"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-base focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition bg-white">
                                @error('email') 
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                <input type="text" wire:model="phone" placeholder="09123456789"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-base focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition bg-white">
                                @error('phone') 
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-5">
                            <!-- Position -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Position <span class="text-red-500">*</span>
                                </label>
                                <input type="text" wire:model="position" placeholder="Senior Stylist"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-base focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition bg-white">
                                @error('position') 
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>

                            <!-- Address -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                <input type="text" wire:model="address" placeholder="123 Main St, City, Country"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-base focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition bg-white">
                                @error('address') 
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" wire:model="password" placeholder="Enter password"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-base focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition bg-white">
                                <p class="text-sm text-gray-400 mt-1">Minimum 8 characters</p>
                                @error('password') 
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Confirm Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" wire:model="password_confirmation" placeholder="Confirm password"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-base focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition bg-white">
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 mt-6 pt-6 border-t border-gray-200">
                        <a href="{{ route('owner.employee') }}"
                            class="w-full sm:w-auto px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-base font-medium text-center">
                            Cancel
                        </a>
                        <button type="submit"
                            class="w-full sm:w-auto px-8 py-3 bg-[#1E7A4A] text-white rounded-lg hover:bg-[#145537] transition text-base font-medium shadow-sm hover:shadow-md flex items-center justify-center gap-2"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove>
                                <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                                Create Employee
                            </span>
                            <span wire:loading>
                                <svg class="animate-spin h-5 w-5 inline mr-2" fill="none" viewBox="0 0 24 24">
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