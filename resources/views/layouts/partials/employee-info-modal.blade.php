{{-- resources/views/layouts/partials/employee-info-modal.blade.php --}}

@if($showProfileModal && $selectedEmployee)
<div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: true }" x-show="show" x-cloak>
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-900 opacity-50"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Make modal scrollable with max-h -->
        <div class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full max-h-[90vh] flex flex-col" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            
            <!-- Modal Header - Fixed -->
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/80 flex items-center justify-between shrink-0">
                <h3 class="text-lg font-semibold text-gray-900">Employee Details</h3>
                <button wire:click="closeProfileModal" class="text-gray-400 hover:text-gray-600 transition p-1 rounded-lg hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Modal Body - Scrollable -->
            <div class="px-6 py-6 overflow-y-auto flex-1">
                <!-- Cover Photo -->
                <div class="relative h-36 sm:h-44 bg-gradient-to-r from-[#1E7A4A] to-emerald-400 rounded-xl overflow-hidden">
                    @if($selectedEmployee->user && $selectedEmployee->user->cover_photo)
                        <img src="{{ Storage::url($selectedEmployee->user->cover_photo) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-r from-[#1E7A4A] to-emerald-500">
                            <svg class="w-14 h-14 text-white/20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Avatar - Overlapping Cover -->
                <div class="relative flex items-end -mt-10 sm:-mt-12 px-1">
                    <div class="relative">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full overflow-hidden border-4 border-white bg-gray-100 shadow-lg">
                            @if($selectedEmployee->user && $selectedEmployee->user->avatar)
                                <img src="{{ Storage::url($selectedEmployee->user->avatar) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-emerald-100">
                                    <span class="text-2xl sm:text-3xl font-bold text-[#1E7A4A]">
                                        {{ strtoupper(substr($selectedEmployee->user?->name ?? 'U', 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        @if($selectedEmployee->user && $selectedEmployee->user->status['is_online'] ?? false)
                            <span class="absolute bottom-1 right-1 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full animate-pulse"></span>
                        @endif
                    </div>
                    
                    <div class="ml-4 sm:ml-5 flex-1 pb-1">
                        <h4 class="text-lg font-bold text-gray-900">{{ $selectedEmployee->user?->name ?? 'Unknown' }}</h4>
                        <p class="text-sm text-gray-500">{{ $selectedEmployee->position ?? 'No Position' }}</p>
                    </div>
                    
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-medium {{ $selectedEmployee->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }} rounded-full mb-1 shrink-0">
                        <span class="w-1.5 h-1.5 rounded-full {{ $selectedEmployee->is_active ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                        {{ $selectedEmployee->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                <!-- Details Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 mt-5 pt-4 border-t border-gray-100">
                    <div>
                        <label class="block text-[10px] font-medium text-gray-400 uppercase tracking-wider">Full Name</label>
                        <p class="text-sm text-gray-900 font-medium">{{ $selectedEmployee->user?->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-[10px] font-medium text-gray-400 uppercase tracking-wider">Email</label>
                        <p class="text-sm text-gray-900 truncate">{{ $selectedEmployee->user?->email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-[10px] font-medium text-gray-400 uppercase tracking-wider">Phone</label>
                        <p class="text-sm text-gray-900">{{ $selectedEmployee->user?->phone ?? 'Not provided' }}</p>
                    </div>
                    <div>
                        <label class="block text-[10px] font-medium text-gray-400 uppercase tracking-wider">Position</label>
                        <p class="text-sm text-gray-900">{{ $selectedEmployee->position ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-[10px] font-medium text-gray-400 uppercase tracking-wider">Hired Date</label>
                        <p class="text-sm text-gray-900">{{ $selectedEmployee->hired_at ? $selectedEmployee->hired_at->format('M d, Y') : 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-[10px] font-medium text-gray-400 uppercase tracking-wider">Commission Rate</label>
                        <p class="text-sm text-gray-900">{{ number_format($selectedEmployee->commission_rate ?? 0, 2) }}%</p>
                    </div>
                    <div>
                        <label class="block text-[10px] font-medium text-gray-400 uppercase tracking-wider">Commission Eligible</label>
                        <p class="text-sm text-gray-900">{{ $selectedEmployee->is_commission_eligible ? '✅ Yes' : '❌ No' }}</p>
                    </div>
                    <div>
                        <label class="block text-[10px] font-medium text-gray-400 uppercase tracking-wider">Account Status</label>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium {{ $selectedEmployee->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }} rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full {{ $selectedEmployee->is_active ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                            {{ $selectedEmployee->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>

                <!-- Bio -->
                @if($selectedEmployee->user && $selectedEmployee->user->bio)
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <label class="block text-[10px] font-medium text-gray-400 uppercase tracking-wider">Bio</label>
                        <p class="text-sm text-gray-700 mt-1 leading-relaxed">{{ $selectedEmployee->user->bio }}</p>
                    </div>
                @endif

                <!-- Permissions -->
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <label class="block text-[10px] font-medium text-gray-400 uppercase tracking-wider">Permissions</label>
                    <div class="flex flex-wrap gap-1.5 mt-2">
                        @if($selectedEmployee->user && $selectedEmployee->user->permissions->count() > 0)
                            @foreach($selectedEmployee->user->permissions as $permission)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium bg-blue-50 text-blue-700 rounded-full border border-blue-200">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                </span>
                            @endforeach
                        @else
                            <span class="text-sm text-gray-400">No permissions assigned</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Modal Footer - Fixed -->
            <div class="px-6 py-4 bg-gray-50/80 border-t border-gray-100 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 shrink-0">
                <button wire:click="closeProfileModal" 
                        class="w-full sm:w-auto px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition shadow-sm">
                    Close
                </button>
                <button class="w-full sm:w-auto px-5 py-2.5 text-sm font-medium text-white bg-[#1E7A4A] rounded-xl hover:bg-[#16653D] transition shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    Send Message
                </button>
            </div>
        </div>
    </div>
</div>
@endif