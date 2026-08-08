
<div>
    <div class="space-y-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100">
            <h1 class="text-xl font-bold text-gray-900">Customers</h1>
            <p class="text-sm text-gray-500 mt-0.5">All customers registered across every shop</p>
        </div>
        <div class="p-4">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by name or email..."
                   class="w-full max-w-sm px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition">
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        <th class="px-6 py-3">Customer</th>
                        <th class="px-6 py-3">Contact</th>
                        <th class="px-6 py-3">Shop</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($this->customers as $customer)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $customer->user?->name ?? 'Unknown' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $customer->user?->email }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $customer->tenant?->name ?? '—' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $customer->user?->is_active ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $customer->user?->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-xs">{{ $customer->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-12 text-center text-gray-400 text-sm">No customers found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">{{ $this->customers->links() }}</div>
    </div>
</div>
</div>