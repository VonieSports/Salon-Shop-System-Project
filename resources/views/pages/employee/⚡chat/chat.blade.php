
<div>
    <div>
    @if($errorMessage)
        <div class="mx-2 sm:mx-4 mt-2 p-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
            {{ $errorMessage }}
        </div>
    @endif
    @if($successMessage)
        <div class="mx-2 sm:mx-4 mt-2 p-3 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
            {{ $successMessage }}
        </div>
    @endif

    <div class="flex flex-col sm:flex-row h-[calc(100vh-70px)] sm:h-[calc(100vh-80px)] md:h-[calc(100vh-90px)] bg-white rounded-none sm:rounded-2xl shadow-none sm:shadow-sm border-0 sm:border border-gray-200 overflow-hidden">
        <div class="w-full sm:w-72 md:w-80 lg:w-96 border-b sm:border-b-0 sm:border-r border-gray-200 flex flex-col bg-gray-50/30 {{ $selectedConversation ? 'hidden sm:flex' : 'flex' }}">
            <div class="p-3 sm:p-4 border-b border-gray-200 bg-white">
                <div class="flex items-center justify-between">
                    <h2 class="text-base sm:text-lg font-semibold text-gray-900">Messages</h2>
                    <button wire:click="startNewChat" 
                            class="p-1.5 sm:p-2 bg-[#1E7A4A] text-white rounded-full hover:bg-[#16633c] transition shadow-sm">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                    </button>
                </div>
                <div class="mt-2 sm:mt-3 relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" 
                           wire:model.live.debounce.300ms="searchTerm" 
                           placeholder="Search conversations..."
                           class="w-full pl-9 pr-3 sm:pr-4 py-1.5 sm:py-2 text-xs sm:text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition bg-white">
                </div>
            </div>

            <div class="flex-1 overflow-y-auto p-1.5 sm:p-2 space-y-0.5 sm:space-y-1">
                @forelse($conversations as $conversation)
                    <div wire:click="selectConversation({{ $conversation->id }})"
                         class="flex items-center gap-2 sm:gap-3 p-2 sm:p-3 rounded-xl hover:bg-gray-100 transition cursor-pointer {{ $selectedConversation && $selectedConversation->id == $conversation->id ? 'bg-gray-100' : '' }}">
                        <div class="relative flex-shrink-0">
                            @if($conversation->type == 'group')
                                <div class="w-9 h-9 sm:w-10 sm:h-11 rounded-full bg-gradient-to-r from-purple-500 to-purple-600 flex items-center justify-center text-white font-bold text-xs sm:text-sm">
                                    {{ substr($conversation->name, 0, 2) }}
                                </div>
                            @else
                                @php
                                    $participant = $conversation->participants()->where('user_id', '!=', auth()->id())->first();
                                @endphp
                                @if($participant && $participant->avatar)
                                    <img src="{{ Storage::url($participant->avatar) }}" 
                                         class="w-9 h-9 sm:w-10 sm:h-11 rounded-full object-cover border-2 border-gray-200">
                                @else
                                    <div class="w-9 h-9 sm:w-10 sm:h-11 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-xs sm:text-sm">
                                        {{ strtoupper(substr($participant->name ?? 'U', 0, 1)) }}
                                    </div>
                                @endif
                            @endif
                            @if($conversation->unread_count > 0)
                                <span class="absolute -top-0.5 -right-0.5 w-4 h-4 sm:w-5 sm:h-5 bg-red-500 text-white text-[9px] sm:text-xs font-bold rounded-full flex items-center justify-center">
                                    {{ $conversation->unread_count }}
                                </span>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <p class="text-xs sm:text-sm font-semibold text-gray-900 truncate max-w-[100px] sm:max-w-[150px] md:max-w-[200px]">
                                    {{ $conversation->display_name }}
                                </p>
                                @if($conversation->last_message_at)
                                    <span class="text-[10px] sm:text-xs text-gray-400 flex-shrink-0 ml-1 sm:ml-2">
                                        {{ $conversation->last_message_at->diffForHumans() }}
                                    </span>
                                @endif
                            </div>
                            <p class="text-[11px] sm:text-sm text-gray-500 truncate">
                                @if($conversation->lastMessage)
                                    {{ $conversation->lastMessage->user_id == auth()->id() ? 'You: ' : '' }}
                                    {{ $conversation->lastMessage->type == 'file' ? '📎 ' : '' }}
                                    {{ Str::limit($conversation->lastMessage->content, 30) }}
                                @else
                                    No messages yet
                                @endif
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 sm:py-12">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 2H4a2 2 0 00-2 2v12a2 2 0 002 2h4l4 4 4-4h4a2 2 0 002-2V4a2 2 0 00-2-2z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01"/>
                        </svg>
                        <p class="text-gray-500 text-xs sm:text-sm">No conversations yet</p>
                        <p class="text-gray-400 text-[10px] sm:text-xs mt-1">Start a new chat to connect</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Chat Area -->
        <div class="flex-1 flex flex-col bg-white {{ !$selectedConversation ? 'hidden sm:flex' : 'flex' }}">
            @if($selectedConversation)
                <!-- Chat Header -->
                <div class="p-2 sm:p-3 md:p-4 border-b border-gray-200 flex items-center gap-2 sm:gap-3 bg-white shrink-0">
                    <button wire:click="$set('selectedConversation', null)" 
                            class="sm:hidden p-1.5 rounded-lg text-gray-500 hover:bg-gray-100 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>

                    @if($selectedConversation->type == 'group')
                        <div class="w-8 h-8 sm:w-9 sm:h-10 rounded-full bg-gradient-to-r from-purple-500 to-purple-600 flex items-center justify-center text-white font-bold text-xs sm:text-sm">
                            {{ substr($selectedConversation->name, 0, 2) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm sm:text-base font-semibold text-gray-900 truncate">{{ $selectedConversation->name }}</p>
                            <p class="text-[10px] sm:text-xs text-gray-500">{{ $selectedConversation->participants->count() }} members</p>
                        </div>
                    @else
                        @php
                            $participant = $selectedConversation->participants()->where('user_id', '!=', auth()->id())->first();
                        @endphp
                        @if($participant && $participant->avatar)
                            <img src="{{ Storage::url($participant->avatar) }}" 
                                 class="w-8 h-8 sm:w-9 sm:h-10 rounded-full object-cover border-2 border-gray-200">
                        @else
                            <div class="w-8 h-8 sm:w-9 sm:h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-sm sm:text-base">
                                {{ strtoupper(substr($participant->name ?? 'U', 0, 1)) }}
                            </div>
                        @endif
                        <div class="min-w-0 flex-1">
                            <p class="text-sm sm:text-base font-semibold text-gray-900 truncate">{{ $participant->name ?? 'Unknown' }}</p>
                            <p class="text-[10px] sm:text-xs text-gray-500 truncate">{{ $participant->position ?? 'Employee' }}</p>
                        </div>
                    @endif
                </div>

                <!-- Messages -->
                <div class="flex-1 overflow-y-auto p-2 sm:p-3 md:p-4 space-y-2 sm:space-y-3 bg-gray-50/30" 
                     x-data="{ scrollBottom() { this.$el.scrollTop = this.$el.scrollHeight } }"
                     x-init="$wire.on('messageLoaded', () => scrollBottom())"
                     x-on:message-loaded.window="scrollBottom()">
                    @if($loading)
                        <div class="flex justify-center py-8">
                            <svg class="animate-spin h-6 w-6 sm:h-8 sm:w-8 text-[#1E7A4A]" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    @else
                        @if($messages->isEmpty())
                            <div class="flex items-center justify-center h-full">
                                <div class="text-center">
                                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                    <p class="text-sm text-gray-500">No messages yet</p>
                                    <p class="text-xs text-gray-400">Send a message to start the conversation</p>
                                </div>
                            </div>
                        @else
                            @foreach($messages as $message)
                                <div class="flex {{ $message->user_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                                    <div class="max-w-[85%] sm:max-w-[75%]">
                                        <div class="flex items-end gap-1 sm:gap-2">
                                            @if($message->user_id != auth()->id())
                                                <div class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-[9px] sm:text-xs flex-shrink-0">
                                                    {{ strtoupper(substr($message->user->name ?? 'U', 0, 1)) }}
                                                </div>
                                            @endif
                                            <div class="flex flex-col">
                                                @if($message->type == 'file' && $message->file_path)
                                                    <div class="bg-gray-100 rounded-lg p-2 sm:p-3">
                                                        <a href="{{ Storage::url($message->file_path) }}" target="_blank" 
                                                           class="flex items-center gap-1.5 sm:gap-2 text-[#1E7A4A] hover:underline text-xs sm:text-sm">
                                                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                                            </svg>
                                                            <span class="truncate max-w-[120px] sm:max-w-[200px]">{{ $message->file_name ?? 'File' }}</span>
                                                        </a>
                                                    </div>
                                                @endif
                                                
                                                @if($message->content)
                                                    <div class="rounded-2xl px-3 py-1.5 sm:px-4 sm:py-2 text-sm sm:text-base {{ $message->user_id == auth()->id() ? 'bg-[#1E7A4A] text-white' : 'bg-white text-gray-800 shadow-sm border border-gray-100' }}">
                                                        {{ $message->content }}
                                                    </div>
                                                @endif
                                                
                                                <span class="text-[9px] sm:text-xs text-gray-400 mt-0.5 sm:mt-1 {{ $message->user_id == auth()->id() ? 'text-right' : '' }}">
                                                    {{ $message->created_at->format('g:i A') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @endif
                </div>

                <!-- Message Input -->
                <div class="p-2 sm:p-3 md:p-4 border-t border-gray-200 bg-white shrink-0">
                    <form wire:submit.prevent="sendMessage" class="flex items-center gap-1.5 sm:gap-3">
                        <label class="cursor-pointer p-1.5 sm:p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition flex-shrink-0">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                            </svg>
                            <input type="file" wire:model="file" accept="image/*,.pdf,.doc,.docx" class="hidden">
                        </label>

                        <input type="text" 
                               wire:model="newMessage" 
                               placeholder="Type a message..." 
                               class="flex-1 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition bg-gray-50"
                               x-on:keydown.enter="$wire.sendMessage()">

                        <button type="submit" 
                                class="p-1.5 sm:p-2 bg-[#1E7A4A] text-white rounded-xl hover:bg-[#16633c] transition disabled:opacity-50 flex-shrink-0"
                                {{ empty($newMessage) && !$file ? 'disabled' : '' }}>
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                        </button>
                    </form>
                    @if($file)
                        <div class="mt-1.5 sm:mt-2 flex items-center gap-1.5 sm:gap-2 bg-gray-50 p-1.5 sm:p-2 rounded-lg border border-gray-200">
                            <span class="text-[11px] sm:text-sm text-gray-600 truncate flex-1">{{ $file->getClientOriginalName() }}</span>
                            <button wire:click="$set('file', null)" class="text-red-500 hover:text-red-700 flex-shrink-0">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>
            @else
                <!-- No Conversation Selected -->
                <div class="flex-1 flex items-center justify-center p-4">
                    <div class="text-center">
                        <svg class="w-12 h-12 sm:w-16 sm:h-20 text-gray-300 mx-auto mb-3 sm:mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 2H4a2 2 0 00-2 2v12a2 2 0 002 2h4l4 4 4-4h4a2 2 0 002-2V4a2 2 0 00-2-2z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01"/>
                        </svg>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-700">Your Messages</h3>
                        <p class="text-xs sm:text-sm text-gray-400 mt-1">Select a conversation or start a new chat</p>
                        <button wire:click="startNewChat" 
                                class="mt-3 sm:mt-4 px-4 sm:px-6 py-1.5 sm:py-2 bg-[#1E7A4A] text-white rounded-xl hover:bg-[#16633c] transition text-xs sm:text-sm font-medium">
                            Start New Chat
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

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
                        <div>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model="isGroupChat" class="rounded text-[#1E7A4A] w-3.5 h-3.5 sm:w-4 sm:h-4">
                                <span class="text-xs sm:text-sm font-medium text-gray-700">Group Chat</span>
                            </label>
                        </div>

                        @if($isGroupChat)
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Group Name</label>
                                <input type="text" wire:model="chatName" 
                                       placeholder="Enter group name..."
                                       class="w-full rounded-lg border border-gray-300 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition">
                            </div>
                        @endif

                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">
                                {{ $isGroupChat ? 'Select Members' : 'Select User' }}
                            </label>
                            
                            <div class="max-h-48 overflow-y-auto border border-gray-200 rounded-lg divide-y divide-gray-100">
                                @forelse($allUsers as $user)
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
                                @empty
                                    <div class="px-3 sm:px-4 py-6 text-center">
                                        <p class="text-xs sm:text-sm text-gray-500">No users available</p>
                                        <p class="text-[10px] sm:text-xs text-gray-400 mt-1">Add employees to start chatting</p>
                                    </div>
                                @endforelse
                            </div>
                            
                            @if(is_array($selectedUsers) && count($selectedUsers) > 0)
                                <p class="text-[10px] sm:text-xs text-green-600 mt-1">
                                    {{ count($selectedUsers) }} user(s) selected
                                </p>
                            @endif
                        </div>

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
</div>
</div>