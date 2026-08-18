<div class="min-h-screen bg-gray-50">
    <div class="w-full">
        <div class="bg-white shadow-sm border-x-0 sm:border-x border-gray-200 overflow-hidden">
            
            <div class="px-4 sm:px-8 py-5 border-b border-gray-100 bg-[#1E7A4A]">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between flex-wrap gap-3">
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-white">Order Management</h1>
                        <p class="text-white/80 text-xs sm:text-sm mt-0.5">Manage fulfillment and payment collection</p>
                    </div>
                </div>
            </div>

            <div class="px-4 sm:px-8 py-5 sm:py-8">

                @if (session()->has('message'))
                    <div class="mb-5 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-medium">
                        {{ session('message') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="mb-5 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm font-medium">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Status Filter Tabs -->
                <div class="flex gap-2 overflow-x-auto border-b border-gray-200 mb-6">
                    <button wire:click="$set('statusFilter', 'all')"
                            class="px-4 py-3 text-sm font-medium whitespace-nowrap border-b-2 -mb-px transition {{ $statusFilter === 'all' ? 'border-[#1E7A4A] text-[#1E7A4A]' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                        All
                    </button>
                    @foreach (App\Enums\OrderStatus::cases() as $status)
                        <button wire:click="$set('statusFilter', '{{ $status->value }}')"
                                class="px-4 py-3 text-sm font-medium whitespace-nowrap border-b-2 -mb-px transition {{ $statusFilter === $status->value ? 'border-[#1E7A4A] text-[#1E7A4A]' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                            {{ $status->label() }}
                            @if (($this->statusCounts[$status->value] ?? 0) > 0)
                                <span class="ml-1.5 bg-gray-200 text-gray-600 text-xs px-2 py-0.5 rounded-full">{{ $this->statusCounts[$status->value] }}</span>
                            @endif
                        </button>
                    @endforeach
                </div>

                <!-- Search -->
                <div class="relative max-w-md mb-6">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search order # or customer..."
                           class="w-full pl-10 pr-4 py-3 text-sm border border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition shadow-sm">
                </div>

                @if ($this->orders->isEmpty())
                    <div class="text-center py-16 bg-white border border-gray-200 rounded-xl">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-gray-500 text-base">No orders found.</p>
                        <p class="text-gray-400 text-sm mt-1">Try adjusting your status filter or search.</p>
                    </div>
                @else
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-700">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="px-6 py-4 font-medium text-gray-500">Order</th>
                                        <th class="px-6 py-4 font-medium text-gray-500">Customer</th>
                                        <th class="px-6 py-4 font-medium text-gray-500">Items</th>
                                        <th class="px-6 py-4 font-medium text-gray-500 text-right">Total</th>
                                        <th class="px-6 py-4 font-medium text-gray-500">Fulfillment</th>
                                        <th class="px-6 py-4 font-medium text-gray-500">Payment</th>
                                        <th class="px-6 py-4 font-medium text-gray-500">Placed</th>
                                        <th class="px-6 py-4 font-medium text-gray-500 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($this->orders as $order)
                                        <tr wire:key="order-{{ $order->id }}" class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 font-medium text-gray-900">#{{ $order->order_number }}</td>
                                            <td class="px-6 py-4 text-gray-700">{{ $order->customer?->name ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 text-gray-600">{{ $order->items->count() }}</td>
                                            <td class="px-6 py-4 text-right font-semibold text-gray-900">₱{{ number_format($order->total, 2) }}</td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full {{ $order->status?->badgeClass() ?? 'bg-gray-100 text-gray-700' }}">
                                                    {{ $order->status?->label() ?? ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full {{ $order->payment_status?->badgeClass() ?? 'bg-gray-100 text-gray-700' }}">
                                                    {{ $order->payment_status?->label() ?? ucfirst($order->payment_status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                                            <td class="px-6 py-4 text-right">
                                                <button wire:click="viewOrder({{ $order->id }})" 
                                                        class="inline-flex items-center px-3 py-1.5 bg-[#1E7A4A]/10 text-[#1E7A4A] text-sm font-medium rounded-lg hover:bg-[#1E7A4A] hover:text-white transition">
                                                    View
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-6">
                        {{ $this->orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Order Detail Modal -->
    @if ($selectedOrder)
    <div class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6">
        <div class="absolute inset-0 bg-black/40" wire:click="closeOrder"></div>
        <div class="relative bg-white rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
            
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between bg-gray-50/50">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Order #{{ $selectedOrder->order_number }}</h3>
                    <p class="text-sm text-gray-500">{{ $selectedOrder->created_at->format('F d, Y g:i A') }}</p>
                </div>
                <button wire:click="closeOrder" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="px-6 py-6 space-y-6">
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                        <p class="text-xs font-medium text-gray-500">Customer</p>
                        <p class="text-base font-medium text-gray-900">{{ $selectedOrder->customer?->name ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-600">{{ $selectedOrder->customer?->email ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-600">{{ $selectedOrder->customer?->phone ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                        <p class="text-xs font-medium text-gray-500">Payment & Status</p>
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full {{ $selectedOrder->payment_status?->badgeClass() ?? 'bg-gray-100 text-gray-700' }}">
                                {{ $selectedOrder->payment_status?->label() ?? ucfirst($selectedOrder->payment_status) }}
                            </span>
                            <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full {{ $selectedOrder->status?->badgeClass() ?? 'bg-gray-100 text-gray-700' }}">
                                {{ $selectedOrder->status?->label() ?? ucfirst($selectedOrder->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div>
                    <p class="text-xs font-medium text-gray-500 mb-3">Order Items</p>
                    <div class="bg-gray-50 rounded-lg p-4 space-y-3 border border-gray-100">
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

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                        <p class="text-xs font-medium text-gray-500">Total Amount</p>
                        <p class="text-2xl font-bold text-gray-900">₱{{ number_format($selectedOrder->total, 2) }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                        <p class="text-xs font-medium text-gray-500">Payment Method</p>
                        <p class="text-sm font-medium text-gray-900">
                            {{ $selectedOrder->payment_type === 'cash' ? 'Cash on Pickup' : 'Online Payment' }}
                        </p>
                    </div>
                </div>

                <!-- Fulfillment Stepper -->
                @if ($selectedOrder->status !== \App\Enums\OrderStatus::CANCELED)
                <div class="border-t border-gray-200 pt-6">
                    <p class="text-xs font-medium text-gray-500 mb-4">Fulfillment Progress</p>
                    @php $currentIndex = $this->selectedOrderStepIndex(); @endphp
                    <div class="flex items-center mb-6">
                        @foreach (\App\Enums\OrderStatus::getFlow() as $stepIndex => $step)
                            @php $done = $stepIndex <= $currentIndex; @endphp
                            <div class="flex-1 flex flex-col items-center relative">
                                @if ($stepIndex > 0)
                                    <div class="absolute top-3 right-1/2 w-full h-1 {{ $stepIndex <= $currentIndex ? 'bg-[#1E7A4A]' : 'bg-gray-200' }}"></div>
                                @endif
                                <div class="relative z-10 w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold {{ $done ? 'bg-[#1E7A4A] text-white' : 'bg-gray-200 text-gray-400' }}">
                                    @if ($done && $stepIndex < $currentIndex)
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    @else
                                        {{ $stepIndex + 1 }}
                                    @endif
                                </div>
                                <p class="text-xs mt-2 text-center {{ $done ? 'text-gray-800 font-medium' : 'text-gray-400' }}">{{ $step->label() }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        @if ($selectedOrder->status->actionLabel())
                            <button wire:click="advanceStatus({{ $selectedOrder->id }})"
                                    class="flex-1 py-2.5 bg-[#1E7A4A] text-white rounded-lg text-sm font-medium hover:bg-[#16633c] transition">
                                {{ $selectedOrder->status->actionLabel() }}
                            </button>
                        @endif
                        @if ($this->canCancelOrder($selectedOrder))
                            <button wire:click="cancelOrder({{ $selectedOrder->id }})" wire:confirm="Cancel this order?"
                                    class="flex-1 py-2.5 border border-red-200 text-red-600 rounded-lg text-sm font-medium hover:bg-red-50 transition">
                                Cancel Order
                            </button>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Manual Payment Actions -->
                <div class="border-t border-gray-200 pt-6">
                    <p class="text-xs font-medium text-gray-500 mb-3">Manual Payment Actions</p>
                    @if ($selectedOrder->payment_status === \App\Enums\PaymentStatus::PAID)
                        <div class="flex items-center gap-2 px-4 py-3 bg-emerald-50 rounded-lg">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-sm font-semibold text-emerald-700">Payment already received</span>
                        </div>
                    @elseif ($selectedOrder->status === \App\Enums\OrderStatus::CANCELED)
                        <p class="text-sm text-gray-400 text-center">Order was canceled — no payment due.</p>
                    @elseif ($selectedOrder->status->canMarkPaid())
                        <button wire:click="markAsPaid({{ $selectedOrder->id }})"
                                class="w-full py-2.5 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700 transition">
                            Mark as Paid
                        </button>
                    @else
                        <p class="text-sm text-amber-600 text-center">Confirm this order before marking it as paid.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>
    @endif
</div>