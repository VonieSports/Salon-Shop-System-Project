@if($showPermissionModal)
  <div class="fixed inset-0 bg-opacity-60 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center">
    <div class="relative p-6 w-full max-w-md mx-4 bg-white rounded-2xl shadow-2xl border border-gray-100 transition-all transform">
        <div class="flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <h3 class="text-xl font-semibold text-gray-800">Manage Permissions</h3>
                </div>
                <button type="button" wire:click="closePermissionModal" class="text-gray-400 hover:text-gray-600 transition-colors p-1 rounded-full hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <p class="text-sm text-gray-500 mb-4 -mt-1">Select the permissions you want to assign to this role.</p>
            <div class="bg-gray-50 rounded-xl p-4 max-h-64 overflow-y-auto custom-scroll">
                <div class="grid grid-cols-1 gap-2">
                    @foreach($allPermissions as $permission)
                    <label class="flex items-center p-2 rounded-lg hover:bg-white transition-colors cursor-pointer group">
                        <input type="checkbox" wire:model="selectedPermissions" value="{{ $permission->name }}"
                            class="w-4 h-4 text-[#1E7A4A] bg-white border-gray-300 rounded focus:ring-blue-500 focus:ring-2 focus:ring-offset-0 transition-all">
                        <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900">{{ ucfirst(str_replace('_', ' ', $permission->name)) }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 mt-6">
                <button type="button" wire:click="closePermissionModal"
                    class="w-full sm:w-auto px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Cancel
                </button>
                <button type="button" wire:click="savePermissions"
                    class="w-full sm:w-auto px-6 py-2.5 text-sm font-medium text-white bg-[#1E7A4A] hover:bg-[#1E7A4A]/90 rounded-xl transition-colors shadow-sm hover:shadow focus:outline-none focus:ring-2 focus:ring-[#1E7A4A] focus:ring-offset-2">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Save Permissions
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>
@endif