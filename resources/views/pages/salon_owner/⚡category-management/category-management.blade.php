<div>
    <div class="min-h-screen bg-gray-50">
        <div class=" mx-auto">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-[#1E7A4A]">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('owner.dashboard') }}"
                            class="p-2 hover:bg-green-100 rounded-lg transition-colors">
                            <svg class="w-5 h-5 text-neutral-50 hover:text-[#1E7A4A]" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </a>
                        <div>

                            <h1 class="text-2xl font-bold text-white">Category Management</h1>
                            <p class="text-white/80 text-sm mt-0.5">
                                Manage your {{ $type === 'product' ? 'product' : 'service' }} categories
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Alert Messages -->
                    @if (session()->has('message'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl">
                        {{ session('message') }}
                    </div>
                    @endif

                    <!-- Type Toggle -->
                    <div class="flex items-center gap-2 bg-gray-100 rounded-xl p-1 mb-6 w-fit">
                        <a href="{{ route('owner.category_management', ['type' => 'product']) }}" wire:navigate
                            class="px-4 py-2 rounded-lg text-sm font-medium transition
                              {{ $type === 'product' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                            Product Categories
                        </a>
                        <a href="{{ route('owner.category_management', ['type' => 'service']) }}" wire:navigate
                            class="px-4 py-2 rounded-lg text-sm font-medium transition
                              {{ $type === 'service' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                            Service Categories
                        </a>
                    </div>

                    <!-- Search -->
                    <div class="mb-6">
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text" wire:model.live.debounce.300ms="search"
                                placeholder="Search categories..."
                                class="w-full max-w-md pl-9 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition text-sm">
                        </div>
                    </div>

                    <!-- Category List -->
                    <div class="bg-gray-50 rounded-xl border border-gray-200 overflow-hidden">
                        @if($categories->isEmpty())
                        <div class="p-12 text-center">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor"
                                stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <p class="text-sm text-gray-500">No categories found</p>
                        </div>
                        @else
                        <table class="w-full">
                            <thead class="bg-gray-100 border-b border-gray-200">
                                <tr>
                                    <th
                                        class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        #</th>
                                    <th
                                        class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Category Name</th>
                                    <th
                                        class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Created</th>
                                    <th
                                        class="px-5 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($categories as $index => $category)
                                <tr class="hover:bg-white transition">
                                    <td class="px-5 py-3 text-sm text-gray-500">{{ $index + 1 }}</td>
                                    <td class="px-5 py-3">
                                        @if($editMode && $editingId === $category->id)
                                        <div class="flex items-center gap-2">
                                            <input type="text" wire:model="name"
                                                class="w-64 px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition">
                                            <button wire:click="update"
                                                class="px-3 py-1.5 bg-[#1E7A4A] text-white rounded-lg hover:bg-[#16633c] transition text-sm font-medium">
                                                Save
                                            </button>
                                            <button wire:click="cancelEdit"
                                                class="px-3 py-1.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm font-medium">
                                                Cancel
                                            </button>
                                        </div>
                                        @else
                                        <span class="text-sm font-medium text-gray-900">{{ $category->name }}</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3 text-sm text-gray-500">{{ $category->created_at->format('M d,
                                        Y') }}</td>
                                    <td class="px-5 py-3 text-right">
                                        @if(!($editMode && $editingId === $category->id))
                                        <div class="flex items-center justify-end gap-2">
                                            <button wire:click="edit({{ $category->id }})"
                                                class="text-blue-600 hover:text-blue-800 transition text-sm font-medium">
                                                Update
                                            </button>
                                            <button wire:click="delete({{ $category->id }})"
                                                wire:confirm="Are you sure you want to delete this category?"
                                                class="text-red-600 hover:text-red-800 transition text-sm font-medium">
                                                Remove
                                            </button>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>

                    <div class="mt-4 text-sm text-gray-500">
                        Total: <span class="font-semibold">{{ $categories->count() }}</span> categories
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>