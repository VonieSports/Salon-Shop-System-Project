<!-- resources/views/livewire/owner/create-employee.blade.php -->
<div class="min-h-screen bg-[#F5F5F5]">
    <div class="max-w-7xl mx-auto ">

        <!-- Alerts -->
        @if (session()->has('error'))
            <div class="bg-[#FDE8E8] border border-[#D6657A]/40 text-[#7A2E3A] px-4 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-[#D6657A] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        @if (session()->has('message'))
            <div class="bg-[#FCE9ED] border border-[#D6657A]/30 text-[#7A3B4A] px-4 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-[#D6657A] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('message') }}
            </div>
        @endif

        <!-- Main Card -->
        <div class="bg-white rounded-lg shadow-sm border border-[#EFEFEF] overflow-hidden">

            <!-- Header with Pink Gradient Background -->
            <div class="bg-gradient-to-r from-[#D6657A] to-[#C25467] px-4 sm:px-6 py-4 sm:py-5">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-white">Add Employee</h1>
                        <p class="text-white/90 text-sm mt-0.5">Create a new employee account</p>
                    </div>
                    <a href="{{ route('owner.employee') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 bg-white text-[#D6657A] hover:bg-[#FFF7F9] text-sm font-semibold rounded-lg transition shadow-sm whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Employees
                    </a>
                </div>
            </div>

            <!-- Form -->
            <div class="p-4 sm:p-6">
                <form wire:submit.prevent="save" enctype="multipart/form-data">

                    <!-- Profile Picture -->
                    <div class="mb-6 pb-6 border-b border-[#EFEFEF]">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4 sm:gap-6">
                            <div class="relative flex-shrink-0">
                                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full overflow-hidden border-4 border-[#EFEFEF] bg-[#F5F5F5] shadow-sm">
                                    @if($avatar)
                                        <img src="{{ $avatar->temporaryUrl() }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-[#F5F5F5]">
                                            <svg class="w-10 h-10 sm:w-12 sm:h-12 text-[#D6657A]/30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <label for="avatar-upload" class="absolute bottom-0 right-0 p-1.5 bg-[#D6657A] rounded-full cursor-pointer hover:bg-[#C25467] transition shadow-md">
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                                    </svg>
                                </label>
                                <input type="file" id="avatar-upload" wire:model="avatar" accept="image/*" class="hidden">
                            </div>
                            <div>
                                <p class="text-sm font-medium text-[#222]">Profile Picture</p>
                                <p class="text-xs text-[#666]">Upload a photo for the employee profile</p>
                                <div class="flex flex-wrap items-center gap-2 mt-1">
                                    <p class="text-[10px] text-[#999]">JPG, PNG. Max 2MB</p>
                                    @if($avatar)
                                        <span class="text-[10px] text-[#999]">|</span>
                                        <button type="button" wire:click="$set('avatar', null)" class="text-[10px] text-red-400 hover:text-red-600 font-medium transition">
                                            Remove
                                        </button>
                                    @endif
                                </div>
                                @error('avatar')
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-[#333] mb-1">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" wire:model="name" placeholder="Enter the full name"
                                    class="w-full px-3 py-2 bg-[#F5F5F5] border-0 rounded-lg focus:ring-2 focus:ring-[#D6657A]/30 text-sm text-[#222] placeholder:text-[#999] transition">
                                @error('name') 
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-[#333] mb-1">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" wire:model="email" placeholder="john@example.com"
                                    class="w-full px-3 py-2 bg-[#F5F5F5] border-0 rounded-lg focus:ring-2 focus:ring-[#D6657A]/30 text-sm text-[#222] placeholder:text-[#999] transition">
                                @error('email') 
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-[#333] mb-1">Phone</label>
                                <input type="text" wire:model="phone" placeholder="09123456789"
                                    class="w-full px-3 py-2 bg-[#F5F5F5] border-0 rounded-lg focus:ring-2 focus:ring-[#D6657A]/30 text-sm text-[#222] placeholder:text-[#999] transition">
                                @error('phone') 
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-[#333] mb-1">
                                    Position <span class="text-red-500">*</span>
                                </label>
                                <input type="text" wire:model="position" placeholder="Senior Stylist"
                                    class="w-full px-3 py-2 bg-[#F5F5F5] border-0 rounded-lg focus:ring-2 focus:ring-[#D6657A]/30 text-sm text-[#222] placeholder:text-[#999] transition">
                                @error('position') 
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-[#333] mb-1">Address</label>
                                <input type="text" wire:model="address" placeholder="123 Main St, City, Country"
                                    class="w-full px-3 py-2 bg-[#F5F5F5] border-0 rounded-lg focus:ring-2 focus:ring-[#D6657A]/30 text-sm text-[#222] placeholder:text-[#999] transition">
                                @error('address') 
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-[#333] mb-1">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" wire:model="password" placeholder="Enter password"
                                    class="w-full px-3 py-2 bg-[#F5F5F5] border-0 rounded-lg focus:ring-2 focus:ring-[#D6657A]/30 text-sm text-[#222] placeholder:text-[#999] transition">
                                <p class="text-xs text-[#999] mt-0.5">Minimum 8 characters</p>
                                @error('password') 
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-[#333] mb-1">
                                    Confirm Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" wire:model="password_confirmation" placeholder="Confirm password"
                                    class="w-full px-3 py-2 bg-[#F5F5F5] border-0 rounded-lg focus:ring-2 focus:ring-[#D6657A]/30 text-sm text-[#222] placeholder:text-[#999] transition">
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 mt-6 pt-6 border-t border-[#EFEFEF]">
                        <a href="{{ route('owner.employee') }}"
                            class="w-full sm:w-auto px-6 py-2 text-sm font-medium text-[#666] hover:text-[#222] transition text-center rounded-lg hover:bg-[#F5F5F5]">
                            Cancel
                        </a>
                        <button type="submit"
                            class="w-full sm:w-auto px-6 py-2 bg-[#D6657A] hover:bg-[#C25467] text-white font-semibold rounded-lg transition text-sm shadow-sm hover:shadow-md flex items-center justify-center gap-2"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove>
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                                Create Employee
                            </span>
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