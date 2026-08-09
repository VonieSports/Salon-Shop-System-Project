
<div>
    <div class="min-h-screen bg-gray-50 py-6">
    <div class=" mx-auto px-4 space-y-5">

        <div>
            <h1 class="text-lg font-semibold text-gray-900">My Orders</h1>
            <p class="text-xs text-gray-400 mt-0.5">All your purchases across shops</p>
        </div>

        <div class="flex gap-1.5 overflow-x-auto pb-1 border-b border-gray-200">
            @foreach (['all' => 'All', 'pending' => 'To Prepare', 'confirmed' => 'Preparing', 'ready_for_pickup' => 'To Pick Up', 'completed' => 'Completed', 'canceled' => 'Canceled'] as $value => $label)
                <button wire:click="$set('statusFilter', '{{ $value }}')"
                        class="px-3.5 py-2 text-xs font-medium whitespace-nowrap border-b-2 -mb-px transition {{ $statusFilter === $value ? 'border-emerald-700 text-emerald-700' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        @if ($this->orders->isEmpty())
            <div class="bg-white rounded-lg border border-gray-200 p-16 text-center text-gray-400 text-sm">No orders found.</div>
        @else
            <div class="space-y-3">
                @foreach ($this->orders as $order)
                    @php
                        $statusLabels = [
                            'pending' => ['To Prepare', 'text-amber-700 bg-amber-50'],
                            'confirmed' => ['Preparing', 'text-blue-700 bg-blue-50'],
                            'ready_for_pickup' => ['To Pick Up', 'text-emerald-700 bg-emerald-50'],
                            'completed' => ['Completed', 'text-gray-600 bg-gray-100'],
                            'canceled' => ['Canceled', 'text-red-700 bg-red-50'],
                        ];
                        [$label, $classes] = $statusLabels[$order->status] ?? ['Unknown', 'text-gray-500 bg-gray-100'];
                    @endphp
                    <a href="{{ route('customer.track_order', $order->id) }}"
                       class="block bg-white rounded-lg border border-gray-200 hover:border-emerald-300 transition overflow-hidden">
                        <div class="px-4 py-2.5 border-b border-gray-100 flex items-center justify-between">
                            <span class="text-xs font-medium text-gray-600">{{ $order->tenant?->name }}</span>
                            <span class="px-2 py-0.5 rounded text-[11px] font-medium {{ $classes }}">{{ $label }}</span>
                        </div>
                        <div class="px-4 py-3 flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-800">{{ $order->items->count() }} item(s) — #{{ $order->order_number }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $order->created_at->format('M d, Y') }}</p>
                            </div>
                            <p class="text-sm font-bold text-gray-900">${{ number_format($order->total, 2) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
            <div>{{ $this->orders->links() }}</div>
        @endif
    </div>
</div>
</div>