<div class="min-h-screen bg-gray-50">
    <div class="w-full">
        <!-- Main Card Wrapper -->
        <div class="bg-white shadow-sm border-x-0 sm:border-x border-gray-200 overflow-hidden">
            
            <!-- GREEN HEADER BAR -->
            <div class="px-3 sm:px-6 py-4 sm:py-5 border-b border-gray-100 bg-[#1E7A4A]">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between flex-wrap gap-3">
                    <div>
                        <h1 class="text-lg sm:text-2xl font-bold text-white">Order Management</h1>
                        <p class="text-white/80 text-xs sm:text-sm mt-0.5">Manage fulfillment and payment collection</p>
                    </div>
                </div>
            </div>

            <!-- BODY CONTENT -->
            <div class="px-3 sm:px-6 py-3 sm:py-6">

                @if (session()->has('message'))
                    <div class="mb-4 p-3 sm:p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-medium">
                        {{ session('message') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="mb-4 p-3 sm:p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm font-medium">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Status Filter Tabs -->
                <div class="flex gap-1.5 overflow-x-auto border-b border-gray-200 mb-4 sm:mb-6">
                    <button wire:click="$set('statusFilter', 'all')"
                            class="px-3.5 py-2 text-xs font-medium whitespace-nowrap border-b-2 -mb-px transition {{ $statusFilter === 'all' ? 'border-[#1E7A4A] text-[#1E7A4A]' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                        All
                    </button>
                    @foreach (App\Enums\OrderStatus::cases() as $status)
                        <button wire:click="$set('statusFilter', '{{ $status->value }}')"
                                class="px-3.5 py-2 text-xs font-medium whitespace-nowrap border-b-2 -mb-px transition {{ $statusFilter === $status->value ? 'border-[#1E7A4A] text-[#1E7A4A]' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                            {{ $status->label() }}
                            @if (($this->statusCounts[$status->value] ?? 0) > 0)
                                <span class="ml-1 text-gray-400">{{ $this->statusCounts[$status->value] }}</span>
                            @endif
                        </button>
                    @endforeach
                </div>

                <!-- Search -->
                <div class="relative max-w-xs mb-4 sm:mb-6">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search order # or customer..."
                           class="w-full pl-9 pr-3 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition shadow-sm">
                </div>

                <!-- Orders Table -->
                @if ($this->orders->isEmpty())
                    <div class="text-center py-12 bg-white border border-gray-200 rounded-xl">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-gray-500 text-sm">No orders found.</p>
                        <p class="text-gray-400 text-sm mt-1">Try adjusting your status filter or search.</p>
                    </div>
                @else
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                        <div class="overflow-x-auto -mx-3 sm:mx-0">
                            <table class="w-full min-w-180 sm:min-w-full">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Order</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Customer</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Items</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Fulfillment</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Payment</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Placed</th>
                                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($this->orders as $order)
                                        <tr wire:key="order-{{ $order->id }}" class="hover:bg-gray-50 transition">
                                            <td class="px-4 py-3 text-sm font-medium text-gray-900">#{{ $order->order_number }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-600">{{ $this->maskName($order->customer?->name) }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-500">{{ $order->items->count() }}</td>
                                            <td class="px-4 py-3 text-sm font-semibold text-gray-900">${{ number_format($order->total, 2) }}</td>
                                            <td class="px-4 py-3">
                                                <span class="px-2 py-0.5 text-xs font-medium rounded {{ $order->status?->badgeClass() ?? 'bg-gray-50 text-gray-700' }}">
                                                    {{ $order->status?->label() ?? ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="px-2 py-0.5 text-xs font-medium rounded {{ $order->payment_status?->badgeClass() ?? 'bg-gray-50 text-gray-700' }}">
                                                    {{ $order->payment_status?->label() ?? ucfirst($order->payment_status) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-xs text-gray-400">{{ $order->created_at->format('M d, Y') }}</td>
                                            <td class="px-4 py-3 text-right">
                                                <button wire:click="viewOrder({{ $order->id }})" class="text-[#1E7A4A] hover:underline text-sm font-medium">View</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-4">
                        {{ $this->orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Order Detail Modal -->
    @if ($selectedOrder)
        <div class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" wire:click="closeOrder"></div>
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
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase mb-1">Customer</p>
                            <p class="text-sm text-gray-800">{{ $this->maskName($selectedOrder->customer?->name) }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                {{ $this->maskEmail($selectedOrder->customer?->email) }} · {{ $this->maskPhone($selectedOrder->customer?->phone) }}
                            </p>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium rounded {{ $selectedOrder->payment_status?->badgeClass() ?? 'bg-gray-50 text-gray-700' }}">
                            {{ $selectedOrder->payment_status?->label() ?? ucfirst($selectedOrder->payment_status) }}
                        </span>
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

                   <div class="border-t border-gray-100 pt-3 space-y-2">
    @if ($selectedOrder->payment_status !== \App\Enums\PaymentStatus::PAID)
        @if ($selectedOrder->status->canMarkPaid())
            <button wire:click="markAsPaid({{ $selectedOrder->id }})"
                    class="w-full px-3 py-2 bg-emerald-600 text-white rounded-md text-xs font-semibold hover:bg-emerald-700 transition">
                Mark as Paid
            </button>
        @else
            <p class="text-xs text-amber-600 text-center">Confirm this order before marking it as paid.</p>
        @endif
    @endif
    
    @if ($selectedOrder->status->getNextStatus())
        <button wire:click="advanceStatus({{ $selectedOrder->id }})"
                class="w-full px-3 py-2 bg-[#1E7A4A] text-white rounded-md text-xs font-semibold hover:bg-[#16633c] transition">
            Proceed "{{ $selectedOrder->status->getNextStatus()->label() }}"
        </button>
    @endif

    @if ($selectedOrder->status->canCancel())
        <button wire:click="cancelOrder({{ $selectedOrder->id }})" wire:confirm="Cancel this order?"
                class="w-full px-3 py-2 border border-red-200 text-red-600 rounded-md text-xs font-semibold hover:bg-red-50 transition">
            Cancel Order
        </button>
    @endif

    @if ($selectedOrder->paymentMethod)
        <p class="text-[11px] text-gray-400 text-center pt-1">Paid via {{ $selectedOrder->paymentMethod->name }}</p>
    @endif
</div>
                </div>
            </div>
        </div>
    @endif
</div>