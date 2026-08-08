<div>
  <div class="min-h-screen bg-gray-50">
      @if ($showUnauthorizedModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"></div>

        <div class="relative bg-white rounded-2xl shadow-xl max-w-md w-full overflow-hidden">
            <div class="p-6 text-center">
                <div class="mx-auto flex items-center justify-center w-14 h-14 rounded-full bg-red-100 mb-4">
                    <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                    </svg>
                </div>

                <h3 class="text-lg font-bold text-gray-900 mb-1.5">Access Restricted</h3>
                <p class="text-sm text-gray-500 leading-relaxed">
                    Only the <span class="font-semibold text-gray-700">Main Headquarters</span> account can create new branches.
                    Branch managers are not permitted to open new locations.
                </p>
            </div>

            <div class="px-6 pb-6">
                <button type="button" wire:click="goToDashboard"
                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-[#1E7A4A] text-white rounded-xl hover:bg-[#16633c] transition text-sm font-medium">
                    Back to Dashboard
                </button>
            </div>
        </div>
    </div>
  @endif
    <div class=" mx-auto space-y-6 py-6 px-4">
        @if (session()->has('success'))
            <div class="bg-green-50 text-green-700 px-5 py-3.5 rounded-xl text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="bg-red-50 text-red-700 px-5 py-3.5 rounded-xl text-sm font-medium">
                {{ session('error') }}
            </div>
        @endif
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 bg-[#1E7A4A] flex items-center gap-3">
                <a href="{{ route('owner.dashboard') }}" class="p-2 hover:bg-green-600/30 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-white">Create New Branch</h1>
                    <p class="text-sm text-white/80 mt-0.5">Register a new branch and assign a manager to run it</p>
                </div>
            </div>
        </div>

        <form wire:submit.prevent="registerBranch" enctype="multipart/form-data" class="space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                    <span class="flex items-center justify-center w-7 h-7 rounded-full bg-[#1E7A4A]/10 text-[#1E7A4A] text-xs font-bold">1</span>
                    <h3 class="text-base font-bold text-gray-900">Branch Details</h3>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                        <div class="lg:col-span-3 space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1.5">Branch Name <span class="text-red-500">*</span></label>
                                <input type="text" wire:model.blur="branchName" placeholder="e.g. Downtown Branch"
                                       class="w-full px-4 py-3 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm text-gray-900">
                                @error('branchName') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Branch Email <span class="text-red-500">*</span></label>
                                    <input type="email" wire:model.blur="branchEmail" placeholder="branch@example.com"
                                           class="w-full px-4 py-3 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm text-gray-900">
                                    @error('branchEmail') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Branch Phone <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model.blur="branchPhone" placeholder="+63 900 000 0000"
                                           class="w-full px-4 py-3 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm text-gray-900">
                                    @error('branchPhone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1.5">Branch Address <span class="text-red-500">*</span></label>
                                <textarea wire:model.blur="branchAddress" rows="3" placeholder="Full branch address"
                                          class="w-full px-4 py-3 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm text-gray-900 resize-none"></textarea>
                                @error('branchAddress') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-gray-100/50">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Business Type</label>
                                    <input type="text" wire:model.blur="branchType" placeholder="e.g. Hair Salon, Nail Spa"
                                           class="w-full px-4 py-3 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm text-gray-900">
                                    @error('branchType') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Business Description</label>
                                    <textarea wire:model.blur="branchDescription" rows="2" placeholder="Tell customers about this branch..."
                                              class="w-full px-4 py-3 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm text-gray-900 resize-none"></textarea>
                                    @error('branchDescription') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="lg:col-span-1 flex flex-col justify-start pt-1">
                            <label class="block text-xs font-medium text-gray-500 mb-2">Branch Logo</label>

                            <div class="w-full max-w-[360px] mx-auto lg:mx-0">
                                <label class="group relative block aspect-square w-full rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 overflow-hidden cursor-pointer hover:border-[#1E7A4A] transition shadow-sm">
                                    @if($branchLogo)
                                        <img src="{{ $branchLogo->temporaryUrl() }}" alt="Branch Logo" class="absolute inset-0 w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition flex items-center justify-center">
                                            <span class="opacity-0 group-hover:opacity-100 text-white text-xs font-medium transition bg-black/50 backdrop-blur-sm px-3 py-1.5 rounded-lg">Change</span>
                                        </div>
                                    @else
                                        <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-400 group-hover:text-[#1E7A4A] transition">
                                            <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/>
                                            </svg>
                                            <span class="text-sm font-medium">Upload</span>
                                            <p class="text-[10px] text-gray-400 mt-1">400x400 px</p>
                                        </div>
                                    @endif
                                    <input type="file" wire:model="branchLogo" accept="image/*" class="hidden">
                                </label>
                                @error('branchLogo') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                <div wire:loading wire:target="branchLogo" class="mt-2 text-xs text-emerald-600 font-medium">Uploading...</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                    <span class="flex items-center justify-center w-7 h-7 rounded-full bg-[#1E7A4A]/10 text-[#1E7A4A] text-xs font-bold">2</span>
                    <h3 class="text-base font-bold text-gray-900">Branch Manager Account</h3>
                </div>
                <div class="p-6 space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">Manager Name <span class="text-red-500">*</span></label>
                            <input type="text" wire:model.blur="managerName" placeholder="Full name"
                                   class="w-full px-4 py-3 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm text-gray-900">
                            @error('managerName') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">Manager Email <span class="text-red-500">*</span></label>
                            <input type="email" wire:model.blur="managerEmail" placeholder="manager@example.com"
                                   class="w-full px-4 py-3 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm text-gray-900">
                            @error('managerEmail') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">Password <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input :type="$wire.showPassword ? 'text' : 'password'"
                                       wire:model.blur="managerPassword" placeholder="Min. 8 characters"
                                       class="w-full px-4 py-3 pr-11 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm text-gray-900">
                                <button type="button" wire:click="togglePassword"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </button>
                            </div>
                            @error('managerPassword') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">Confirm Password <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input :type="$wire.showConfirmPassword ? 'text' : 'password'"
                                       wire:model.blur="managerPasswordConfirmation" placeholder="Re-enter password"
                                       class="w-full px-4 py-3 pr-11 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm text-gray-900">
                                <button type="button" wire:click="toggleConfirmPassword"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </button>
                            </div>
                            @error('managerPasswordConfirmation') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="bg-amber-50 border border-amber-100 rounded-xl px-4 py-3 text-xs text-amber-700">
                        This branch will be submitted with <strong>pending</strong> verification status and will require admin approval before it becomes active.
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('owner.dashboard') }}"
                   class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition text-sm font-medium">
                    Cancel
                </a>
                <button type="submit" wire:loading.attr="disabled" wire:target="registerBranch"
                        class="inline-flex items-center justify-center gap-2 px-8 py-2.5 bg-[#1E7A4A] text-white rounded-xl hover:bg-[#16633c] transition text-sm font-medium shadow-sm disabled:opacity-60">
                    <span wire:loading.remove wire:target="registerBranch">Create Branch</span>
                    <span wire:loading wire:target="registerBranch">Creating...</span>
                </button>
            </div>
        </form>
    </div>
  </div>
</div>