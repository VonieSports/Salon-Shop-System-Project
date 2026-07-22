@if($showChatActions)
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: true }" x-show="show" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-3 sm:px-4">
            <div class="fixed inset-0 bg-gray-500/75 transition-opacity" @click="show = false; $wire.set('showChatActions', false)"></div>
            
            <div class="relative bg-white rounded-2xl max-w-sm w-full p-4 sm:p-6 shadow-xl mx-3 sm:mx-4">
                <div class="flex items-center justify-between mb-3 sm:mb-4">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">Chat Options</h3>
                    <button wire:click="$set('showChatActions', false)" class="text-gray-400 hover:text-gray-500 p-1">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="space-y-2">
                    <!-- Block User -->
                    @if($selectedConversation && $selectedConversation->type != 'group')
                        @php
                            $otherUser = $selectedConversation->participants()->where('user_id', '!=', auth()->id())->first();
                        @endphp
                        @if($otherUser)
                            <button wire:click="toggleBlockUser({{ $otherUser->id }})" 
                                    class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition text-left
                                           {{ $otherUser->is_blocked ? 'bg-green-50 text-green-700 hover:bg-green-100' : 'bg-red-50 text-red-700 hover:bg-red-100' }}">
                                @if($otherUser->is_blocked)
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Unblock {{ $otherUser->name }}</span>
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                    </svg>
                                    <span>Block {{ $otherUser->name }}</span>
                                @endif
                            </button>
                        @endif
                    @endif

                    <!-- Delete Conversation -->
                    <button wire:click="deleteConversation" 
                            wire:confirm="Are you sure you want to delete this conversation? This action cannot be undone."
                            class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium text-red-700 hover:bg-red-50 rounded-lg transition text-left">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        <span>Delete Conversation</span>
                    </button>

                    <!-- Cancel -->
                    <button wire:click="$set('showChatActions', false)" 
                            class="w-full px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm font-medium">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif