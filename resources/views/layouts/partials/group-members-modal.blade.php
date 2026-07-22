@if($showMembersModal && $selectedConversation)
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: true }" x-show="show" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-3 sm:px-4">
            <div class="fixed inset-0 bg-gray-500/75 transition-opacity" @click="show = false; $wire.set('showMembersModal', false)"></div>
            
            <div class="relative bg-white rounded-2xl max-w-sm sm:max-w-md w-full p-4 sm:p-6 shadow-xl mx-3 sm:mx-4 max-h-[90vh] flex flex-col">
                <div class="flex items-center justify-between mb-3 sm:mb-4 shrink-0">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">Conversation Members</h3>
                    <button wire:click="$set('showMembersModal', false)" class="text-gray-400 hover:text-gray-500 p-1">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Search Members -->
                <div class="relative mb-3 shrink-0">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" 
                           wire:model.live.debounce.300ms="memberSearch" 
                           placeholder="Search members..."
                           class="w-full pl-9 pr-3 sm:pr-4 py-1.5 sm:py-2 text-xs sm:text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition bg-white">
                </div>

                <!-- Members List -->
                <div class="flex-1 overflow-y-auto space-y-1">
                    @php
                        $members = $selectedConversation->participants;
                        if ($memberSearch) {
                            $members = $members->filter(function($p) use ($memberSearch) {
                                return stripos($p->name, $memberSearch) !== false;
                            });
                        }
                    @endphp
                    
                    @forelse($members as $member)
                        <div class="flex items-center justify-between gap-2 px-3 py-2 hover:bg-gray-50 rounded-lg transition">
                            <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                                @if($member->avatar)
                                    <img src="{{ Storage::url($member->avatar) }}" class="w-7 h-7 sm:w-8 sm:h-8 rounded-full object-cover flex-shrink-0">
                                @else
                                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-xs flex-shrink-0">
                                        {{ strtoupper(substr($member->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">{{ $member->name }}</p>
                                    <p class="text-[10px] sm:text-xs text-gray-500 truncate">{{ $member->pivot ? 'Member' : '' }}</p>
                                </div>
                            </div>
                            
                            <!-- Remove member button (only for group chats and not the current user) -->
                            @if($selectedConversation->type == 'group' && $member->id != auth()->id())
                                <button wire:click="removeMember({{ $member->id }})" 
                                        wire:confirm="Remove {{ $member->name }} from this group?"
                                        class="p-1 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-6">
                            <p class="text-sm text-gray-500">No members found</p>
                        </div>
                    @endforelse
                </div>

                <!-- Add Members Section (only for group chats) -->
                @if($selectedConversation->type == 'group')
                    <div class="border-t border-gray-200 pt-3 mt-3 shrink-0">
                        <p class="text-xs font-medium text-gray-700 mb-2">Add Members</p>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" 
                                   wire:model.live.debounce.300ms="addMemberSearch" 
                                   placeholder="Search users to add..."
                                   class="w-full pl-9 pr-3 sm:pr-4 py-1.5 sm:py-2 text-xs sm:text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition bg-white">
                        </div>
                        
                        <!-- Available users to add -->
                        <div class="mt-2 max-h-32 overflow-y-auto space-y-1">
                            @forelse($availableUsersToAdd as $user)
                                <div class="flex items-center justify-between gap-2 px-3 py-1.5 hover:bg-gray-50 rounded-lg transition">
                                    <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                                        @if($user->avatar)
                                            <img src="{{ Storage::url($user->avatar) }}" class="w-6 h-6 sm:w-7 sm:h-7 rounded-full object-cover flex-shrink-0">
                                        @else
                                            <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-[10px] flex-shrink-0">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <p class="text-xs sm:text-sm text-gray-700 truncate">{{ $user->name }}</p>
                                    </div>
                                    <button wire:click="addMemberToGroup({{ $user->id }})" 
                                            class="px-2 py-0.5 text-xs font-medium bg-[#1E7A4A] text-white rounded hover:bg-[#16633c] transition flex-shrink-0">
                                        Add
                                    </button>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 text-center py-2">No users available to add</p>
                            @endforelse
                        </div>
                    </div>
                @endif

                <!-- Close Button -->
                <div class="mt-3 shrink-0">
                    <button wire:click="$set('showMembersModal', false)" 
                            class="w-full px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm font-medium">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif