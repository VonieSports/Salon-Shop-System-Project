<?php

use App\Models\Order;
use App\Models\PendingPayment;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.customer')] class extends Component
{
    public PendingPayment $pending;
    public Order $order;

    public function mount($id): void
    {
        $this->pending = PendingPayment::where('paymongo_link_id', $id)
            ->where('status', 'pending')
            ->firstOrFail();

        $orderId = $this->pending->order_data['order_id'] ?? null;
        
        if (!$orderId) {
            abort(404, 'Order not found for this payment link.');
        }

        $this->order = Order::findOrFail($orderId);
        abort_unless($this->order->user_id === auth()->id(), 403);
    }
};