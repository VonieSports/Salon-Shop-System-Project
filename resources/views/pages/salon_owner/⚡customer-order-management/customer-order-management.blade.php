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
        <div class="absolute inset-0 bg-black/40" wire:click="closeOrder"></div>
        <div class="relative bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Order #{{ $selectedOrder->order_number }}</h3>
                    <p class="text-sm text-gray-500">{{ $selectedOrder->created_at->format('F d, Y g:i A') }}</p>
                </div>
                <button wire:click="closeOrder" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <div class="px-6 py-5 space-y-4">
                
                <!-- Customer Info -->
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Customer Information</p>
                    <div class="bg-gray-50 rounded-lg p-4 space-y-1">
                        <p class="text-sm font-medium text-gray-900">{{ $this->maskName($selectedOrder->customer?->name) }}</p>
                        <p class="text-sm text-gray-600">{{ $this->maskEmail($selectedOrder->customer?->email) }}</p>
                        <p class="text-sm text-gray-600">{{ $this->maskPhone($selectedOrder->customer?->phone) }}</p>
                    </div>
                </div>

                <!-- Status & Payment -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Status</p>
                        <div class="bg-gray-50 rounded-lg px-4 py-2.5">
                            <span class="text-sm font-medium text-gray-900">{{ $selectedOrder->status?->label() ?? ucfirst($selectedOrder->status) }}</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Payment</p>
                        <div class="bg-gray-50 rounded-lg px-4 py-2.5">
                            <span class="text-sm font-medium text-gray-900">{{ $selectedOrder->payment_status?->label() ?? ucfirst($selectedOrder->payment_status) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Order Items</p>
                    <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                        @foreach ($selectedOrder->items as $item)
                            <div class="flex items-center justify-between text-sm border-b border-gray-200 last:border-0 pb-3 last:pb-0">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $item->name }}</p>
                                    <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}</p>
                                </div>
                                <span class="font-medium text-gray-900">₱{{ number_format($item->subtotal, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Total -->
                <div class="border-t border-gray-200 pt-4 flex items-center justify-between">
                    <p class="text-sm font-medium text-gray-700">Total Amount</p>
                    <p class="text-xl font-bold text-gray-900">₱{{ number_format($selectedOrder->total, 2) }}</p>
                </div>

                <!-- Payment Method -->
                <div class="border-t border-gray-200 pt-4">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Payment Method</span>
                        <span class="font-medium text-gray-900">
                            {{ $selectedOrder->payment_type === 'cash' ? 'Cash on Pickup' : 'Online Payment' }}
                        </span>
                    </div>
                    @if ($selectedOrder->paymentMethod)
                        <div class="flex items-center justify-between text-sm mt-2 pt-2 border-t border-gray-100">
                            <span class="text-gray-600">Paid via</span>
                            <span class="font-medium text-gray-900">{{ $selectedOrder->paymentMethod->name }}</span>
                        </div>
                    @endif
                </div>

     @if ($selectedOrder->status !== \App\Enums\OrderStatus::CANCELED)
    <div class="border-t border-gray-100 pt-4">
        <p class="text-xs font-semibold text-gray-400 uppercase mb-3">Fulfillment Status</p>

        @php $currentIndex = $this->selectedOrderStepIndex(); @endphp
        <div class="flex items-center mb-4">
            @foreach (\App\Enums\OrderStatus::getFlow() as $stepIndex => $step)
                @php $done = $stepIndex <= $currentIndex; @endphp
                <div class="flex-1 flex flex-col items-center relative">
                    @if ($stepIndex > 0)
                        <div class="absolute top-2.5 right-1/2 w-full h-0.5 {{ $stepIndex <= $currentIndex ? 'bg-[#1E7A4A]' : 'bg-gray-200' }}"></div>
                    @endif
                    <div class="relative z-10 w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold {{ $done ? 'bg-[#1E7A4A] text-white' : 'bg-gray-200 text-gray-400' }}">
                        @if ($done && $stepIndex < $currentIndex)
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        @else
                            {{ $stepIndex + 1 }}
                        @endif
                    </div>
                    <p class="text-[10px] mt-1.5 text-center {{ $done ? 'text-gray-700 font-medium' : 'text-gray-400' }}">{{ $step->label() }}</p>
                </div>
            @endforeach
        </div>

        @if ($selectedOrder->status->actionLabel())
            <button wire:click="advanceStatus({{ $selectedOrder->id }})"
                    class="w-full px-3 py-2 bg-[#1E7A4A] text-white rounded-md text-xs font-semibold hover:bg-[#16633c] transition">
                {{ $selectedOrder->status->actionLabel() }}
            </button>
        @else
            <p class="text-xs text-gray-400 text-center">This order has completed its fulfillment cycle.</p>
        @endif

        @if ($this->canCancelOrder($selectedOrder))
            <button wire:click="cancelOrder({{ $selectedOrder->id }})" wire:confirm="Cancel this order?"
                    class="w-full mt-2 px-3 py-2 border border-red-200 text-red-600 rounded-md text-xs font-semibold hover:bg-red-50 transition">
                Cancel Order
            </button>
        @elseif ($selectedOrder->payment_type === 'online' && $selectedOrder->payment_status === \App\Enums\PaymentStatus::PAID && $selectedOrder->status->canCancel())
            <p class="text-[11px] text-gray-400 text-center mt-2">Paid online — this order can no longer be canceled.</p>
        @endif
    </div>
@else
    <div class="border-t border-gray-100 pt-4">
        <p class="text-sm text-red-600 font-medium text-center">This order was canceled.</p>
    </div>
@endif

<div class="border-t border-gray-100 pt-4">
    <p class="text-xs font-semibold text-gray-400 uppercase mb-2">Payment</p>
    <div class="flex items-center justify-between text-xs mb-3">
        <span class="text-gray-500">Method</span>
        <span class="font-medium text-gray-700">{{ $selectedOrder->payment_type === 'cash' ? 'Cash on Pickup' : 'PayMongo (Online)' }}</span>
    </div>

    @if ($selectedOrder->payment_status === \App\Enums\PaymentStatus::PAID)
        <div class="flex items-center gap-2 px-3 py-2 bg-emerald-50 rounded-md">
            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            <span class="text-xs font-semibold text-emerald-700">Payment Received</span>
        </div>
    @elseif ($selectedOrder->status === \App\Enums\OrderStatus::CANCELED)
        <p class="text-xs text-gray-400 text-center">Order was canceled — no payment due.</p>
    @elseif ($selectedOrder->status->canMarkPaid())
        <button wire:click="markAsPaid({{ $selectedOrder->id }})"
                class="w-full px-3 py-2 bg-emerald-600 text-white rounded-md text-xs font-semibold hover:bg-emerald-700 transition">
            Mark as Paid
        </button>
    @else
        <p class="text-xs text-amber-600 text-center">Confirm this order before marking it as paid.</p>
    @endif
</div>

    @if ($selectedOrder->paymentMethod)
        <p class="text-[11px] text-gray-400 text-center pt-2">Recorded via {{ $selectedOrder->paymentMethod->name }}</p>
    @endif
</div>
            </div>
        </div>
    </div>
@endif
</div>