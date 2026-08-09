
<div>
 <div class="min-h-screen bg-gray-50 p-4 space-y-5">

    @if (session()->has('message'))
        <div class="bg-emerald-50 text-emerald-700 px-4 py-3 rounded-lg text-sm font-medium">{{ session('message') }}</div>
    @endif

    <div>
        <h1 class="text-xl font-bold text-gray-900">Order Management</h1>
        <p class="text-sm text-gray-500 mt-0.5">Manage and fulfill customer orders</p>
    </div>

    <div class="flex gap-1.5 overflow-x-auto border-b border-gray-200">
        @foreach (['all' => 'All', 'pending' => 'New', 'confirmed' => 'Preparing', 'ready_for_pickup' => 'Ready for Pickup', 'completed' => 'Completed', 'canceled' => 'Canceled'] as $value => $label)
            <button wire:click="$set('statusFilter', '{{ $value }}')"
                    class="px-3.5 py-2 text-xs font-medium whitespace-nowrap border-b-2 -mb-px transition {{ $statusFilter === $value ? 'border-[#1E7A4A] text-[#1E7A4A]' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                {{ $label }}
                @if ($value !== 'all' && ($this->statusCounts[$value] ?? 0) > 0)
                    <span class="ml-1 text-gray-400">{{ $this->statusCounts[$value] }}</span>
                @endif
            </button>
        @endforeach
    </div>

    <div class="relative max-w-xs">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search order # or customer..."
               class="w-full pl-9 pr-3 py-2 text-sm border border-gray-200 rounded-lg bg-white focus:ring-1 focus:ring-[#1E7A4A]">
    </div>

    @if ($this->orders->isEmpty())
        <div class="bg-white rounded-lg border border-gray-200 p-16 text-center text-gray-400 text-sm">No orders found.</div>
    @else
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2.5 text-left text-xs font-medium text-gray-500">Order</th>
                            <th class="px-4 py-2.5 text-left text-xs font-medium text-gray-500">Customer</th>
                            <th class="px-4 py-2.5 text-left text-xs font-medium text-gray-500">Items</th>
                            <th class="px-4 py-2.5 text-left text-xs font-medium text-gray-500">Total</th>
                            <th class="px-4 py-2.5 text-left text-xs font-medium text-gray-500">Status</th>
                            <th class="px-4 py-2.5 text-left text-xs font-medium text-gray-500">Placed</th>
                            <th class="px-4 py-2.5 text-right text-xs font-medium text-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($this->orders as $order)
                            @php
                                $statusStyles = [
                                    'pending' => 'bg-amber-50 text-amber-700',
                                    'confirmed' => 'bg-blue-50 text-blue-700',
                                    'ready_for_pickup' => 'bg-emerald-50 text-emerald-700',
                                    'completed' => 'bg-gray-100 text-gray-600',
                                    'canceled' => 'bg-red-50 text-red-700',
                                ];
                                $statusLabels = [
                                    'pending' => 'New', 'confirmed' => 'Preparing',
                                    'ready_for_pickup' => 'Ready for Pickup', 'completed' => 'Completed', 'canceled' => 'Canceled',
                                ];
                            @endphp
                            <tr wire:key="order-{{ $order->id }}" class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">#{{ $order->order_number }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $this->maskName($order->customer?->name) }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $order->items->count() }}</td>
                                <td class="px-4 py-3 text-sm font-semibold text-gray-900">${{ number_format($order->total, 2) }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-0.5 text-xs font-medium rounded {{ $statusStyles[$order->status] ?? 'bg-gray-100 text-gray-600' }}">
                                        {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-xs text-gray-400">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="px-4 py-3 text-right">
                                    <button wire:click="viewOrder({{ $order->id }})" class="text-[#1E7A4A] hover:underline text-xs font-medium">View</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div>{{ $this->orders->links() }}</div>
    @endif

    @if ($selectedOrder)
        <div class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-gray-900/50" wire:click="closeOrder"></div>
            <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full max-h-[85vh] overflow-y-auto">
                <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">Order #{{ $selectedOrder->order_number }}</h3>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $selectedOrder->created_at->format('M d, Y g:i A') }}</p>
                    </div>
                    <button wire:click="closeOrder" class="p-1.5 rounded-lg hover:bg-gray-100 transition">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="p-5 space-y-4">
                    <!-- Customer privacy block: masked contact info -->
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase mb-1.5">Customer</p>
                        <p class="text-sm text-gray-800">{{ $this->maskName($selectedOrder->customer?->name) }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ $this->maskEmail($selectedOrder->customer?->email) }} · {{ $this->maskPhone($selectedOrder->customer?->phone) }}
                        </p>
                    </div>

                    <div class="border-t border-gray-100 pt-3 space-y-2">
                        @foreach ($selectedOrder->items as $item)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-700">{{ $item->name }} × {{ $item->quantity }}</span>
                                <span class="font-medium text-gray-900">${{ number_format($item->subtotal, 2) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-100 pt-3 flex items-center justify-between">
                        <p class="text-sm font-medium text-gray-700">Total</p>
                        <p class="text-lg font-bold text-[#1E7A4A]">${{ number_format($selectedOrder->total, 2) }}</p>
                    </div>

                    @if (!in_array($selectedOrder->status, ['completed', 'canceled'], true))
                        <div class="border-t border-gray-100 pt-3 flex gap-2">
                            <button wire:click="advanceStatus({{ $selectedOrder->id }})"
                                    class="flex-1 px-3 py-2 bg-[#1E7A4A] text-white rounded-md text-xs font-semibold hover:bg-[#16633c] transition">
                                Advance to Next Step
                            </button>
                            @if (in_array($selectedOrder->status, ['pending', 'confirmed'], true))
                                <button wire:click="cancelOrder({{ $selectedOrder->id }})" wire:confirm="Cancel this order?"
                                        class="px-3 py-2 border border-red-200 text-red-600 rounded-md text-xs font-semibold hover:bg-red-50 transition">
                                    Cancel
                                </button>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
</div>