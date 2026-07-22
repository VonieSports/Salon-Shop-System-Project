@if($showNewChatModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: true }" x-show="show" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-3 sm:px-4">
            <div class="fixed inset-0 bg-gray-500/75 transition-opacity" @click="show = false; $wire.$set('showNewChatModal', false)"></div>
            
            <div class="relative bg-white rounded-2xl max-w-sm sm:max-w-md w-full p-4 sm:p-6 shadow-xl mx-3 sm:mx-4">
                <div class="flex items-center justify-between mb-3 sm:mb-4">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">New Chat</h3>
                    <button wire:click="$set('showNewChatModal', false)" class="text-gray-400 hover:text-gray-500 p-1">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="space-y-3 sm:space-y-4">
                    <!-- Group Chat Toggle -->
                    <div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model.live="isGroupChat" class="rounded text-[#1E7A4A] w-3.5 h-3.5 sm:w-4 sm:h-4">
                            <span class="text-xs sm:text-sm font-medium text-gray-700">Group Chat</span>
                        </label>
                    </div>

                    <!-- Group Name -->
                    @if($isGroupChat)
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Group Name</label>
                            <input type="text" wire:model="chatName" 
                                   placeholder="Enter group name..."
                                   class="w-full rounded-lg border border-gray-300 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition">
                        </div>
                    @endif

                    <!-- User Selection - Only show users NOT already in conversation -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">
                            {{ $isGroupChat ? 'Select Members' : 'Select User' }}
                        </label>
                        
                        <div class="max-h-48 overflow-y-auto border border-gray-200 rounded-lg divide-y divide-gray-100">
                            @forelse($allUsers as $user)
                                @php
                                    // Check if user is already in the conversation (for editing)
                                    $isInConversation = $selectedConversation && $selectedConversation->participants->contains($user->id);
                                @endphp
                                
                                @if(!$isInConversation || !$selectedConversation)
                                    <label class="flex items-center gap-2 sm:gap-3 px-3 sm:px-4 py-2 hover:bg-gray-50 cursor-pointer transition">
                                        <input type="{{ $isGroupChat ? 'checkbox' : 'radio' }}" 
                                               name="selected_users"
                                               value="{{ $user->id }}"
                                               wire:model.live="selectedUsers"
                                               class="rounded {{ $isGroupChat ? 'rounded' : 'rounded-full' }} text-[#1E7A4A] focus:ring-[#1E7A4A]">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">{{ $user->name }}</p>
                                            <p class="text-[10px] sm:text-xs text-gray-500 truncate">{{ $user->position ?? 'Employee' }}</p>
                                        </div>
                                        @if($user->avatar)
                                            <img src="{{ Storage::url($user->avatar) }}" class="w-6 h-6 sm:w-8 sm:h-8 rounded-full object-cover flex-shrink-0">
                                        @else
                                            <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-xs flex-shrink-0">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </label>
                                @endif
                            @empty
                                <div class="px-3 sm:px-4 py-6 text-center">
                                    <p class="text-xs sm:text-sm text-gray-500">No users available</p>
                                    <p class="text-[10px] sm:text-xs text-gray-400 mt-1">Add employees to start chatting</p>
                                </div>
                            @endforelse
                        </div>
                        
                        @if(is_array($selectedUsers) && count($selectedUsers) > 0)
                            <p class="text-[10px] sm:text-xs text-green-600 mt-1">
                                ✅ {{ count($selectedUsers) }} user(s) selected
                            </p>
                        @endif
                    </div>

                    <!-- Create Button -->
                    <button wire:click="createNewChat" 
                            wire:loading.attr="disabled"
                            class="w-full bg-[#1E7A4A] text-white rounded-lg px-4 py-1.5 sm:py-2 hover:bg-[#16633c] transition text-xs sm:text-sm font-medium disabled:opacity-50 disabled:cursor-not-allowed"
                            {{ is_array($selectedUsers) && count($selectedUsers) > 0 ? '' : 'disabled' }}>
                        <span wire:loading.remove>{{ $isGroupChat ? 'Create Group' : 'Start Chat' }}</span>
                        <span wire:loading>
                            <svg class="inline animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Creating...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif