<div class="min-h-screen bg-gray-50 py-6">
    <div class=" mx-auto px-4 space-y-5">

        <div>
            <h1 class="text-lg font-semibold text-gray-900">My Orders</h1>
            <p class="text-xs text-gray-400 mt-0.5">All your purchases across shops</p>
        </div>

       <div class="flex gap-1.5 overflow-x-auto pb-1 border-b border-gray-200">
    <button wire:click="$set('statusFilter', 'all')"
            class="px-3.5 py-2 text-xs font-medium whitespace-nowrap border-b-2 -mb-px transition {{ $statusFilter === 'all' ? 'border-emerald-700 text-emerald-700' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
        All
    </button>
    @foreach (\App\Enums\OrderStatus::cases() as $status)
        <button wire:click="$set('statusFilter', '{{ $status->value }}')"
                class="px-3.5 py-2 text-xs font-medium whitespace-nowrap border-b-2 -mb-px transition {{ $statusFilter === $status->value ? 'border-emerald-700 text-emerald-700' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
            {{ $status->label() }}
        </button>
    @endforeach
</div>

@if ($this->orders->isEmpty())
    <div class="bg-white rounded-lg border border-gray-200 p-16 text-center text-gray-400 text-sm">No orders found.</div>
@else
    <div class="space-y-3">
        @foreach ($this->orders as $order)
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="px-4 py-2.5 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span class="text-xs font-medium text-gray-600">{{ $order->tenant?->name }}</span>
                    </div>
                    <span class="px-2 py-0.5 rounded text-[11px] font-medium {{ $order->status->badgeClass() }}">{{ $order->status->label() }}</span>
                </div>

                <div class="divide-y divide-gray-50">
                    @foreach ($order->items as $item)
                        <div class="flex items-center gap-3 px-4 py-3">
                            <div class="w-12 h-12 rounded-md bg-gray-100 overflow-hidden shrink-0 border border-gray-100">
                                @if ($item->product?->image)
                                    <img src="{{ Storage::url($item->product->image) }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-800 truncate">{{ $item->name }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">Qty: {{ $item->quantity }}</p>
                            </div>
                            <span class="text-sm font-medium text-gray-800 shrink-0">${{ number_format($item->subtotal, 2) }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="px-4 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-1.5 text-xs">
                        @if ($order->status === \App\Enums\OrderStatus::COMPLETED)
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-emerald-700 font-medium">Picked up</span>
                        @else
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-gray-500">Not yet picked up</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-bold text-gray-900">${{ number_format($order->total, 2) }}</span>
                        <a href="{{ route('customer.track_order', $order->id) }}" class="text-xs font-semibold text-emerald-700 hover:underline">Track Order</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div>{{ $this->orders->links() }}</div>
@endif
    </div>
</div>