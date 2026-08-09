<?php

use App\Models\Order;
use App\Support\PrivacyMasker;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.customer')] class extends Component
{
    public Order $order;

    public const STEPS = [
        'pending' => 'Order Placed',
        'confirmed' => 'Preparing Order',
        'ready_for_pickup' => 'Ready for Pickup',
        'completed' => 'Picked Up',
    ];

    /**
     * $order arrives here already resolved by Laravel's implicit route
     * model binding (the {order} segment matches this parameter name).
     * We still must verify ownership manually, since binding alone
     * doesn't scope to the logged-in user.
     */
    public function mount(Order $order): void
    {
        abort_unless($order->user_id === Auth::id(), 404);

        $this->order = $order->load(['tenant:id,name,logo,address,phone', 'items', 'customer']);
    }

    public function currentStepIndex(): int
    {
        $index = array_search($this->order->status, array_keys(self::STEPS), true);
        return $index === false ? 0 : $index;
    }

    public function cancelOrder(): void
    {
        if (!in_array($this->order->status, ['pending', 'confirmed'], true)) {
            return;
        }

        $this->order->update(['status' => 'canceled']);
        $this->order->refresh();
        session()->flash('success', 'Your order has been canceled.');
    }

    public function maskedName(): string
    {
        return PrivacyMasker::name(Auth::user()->name);
    }
};