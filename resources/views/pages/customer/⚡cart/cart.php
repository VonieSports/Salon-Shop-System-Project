<?php

use App\Models\Tenant;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.customer')] class extends Component
{
    public array $selectedItems = [];
    public array $groupSelection = [];
    
    public bool $selectAll = false;

    public function mount()
    {
        if ($this->cartItems->count() === 1) {
            $this->selectedItems = $this->cartItems->pluck('cart_item_id')->toArray();
        }
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedItems = $this->cartItems->pluck('cart_item_id')->toArray();
        } else {
            $this->selectedItems = [];
        }
    }

    #[Computed]
    public function cartItems()
    {
        return app(CartService::class)->getCart();
    }

    #[Computed]
    public function groupedCartItems()
    {
        $items = $this->cartItems;
        if ($items->isEmpty()) return collect();

        $grouped = $items->groupBy('tenant_id');

        $tenants = Tenant::whereIn('id', $grouped->keys())->select('id', 'name', 'logo')->get()->keyBy('id');

        return $grouped->map(function ($groupItems, $tenantId) use ($tenants) {
            return [
                'tenant' => $tenants->get((int) $tenantId),
                'items' => $groupItems,
            ];
        });
    }

    #[Computed]
    public function totalItems(): int
    {
        return $this->cartItems->sum('quantity');
    }

    #[Computed]
    public function grandTotal(): float
    {
        $selectedIds = $this->selectedItems;
        return (float) $this->cartItems
            ->filter(fn($item) => in_array($item['cart_item_id'], $selectedIds))
            ->sum(fn($item) => $item['unit_price'] * $item['quantity']);
    }

    public function updatedGroupSelection($value, $tenantId)
    {
        $group = $this->groupedCartItems->get((int) $tenantId);
        if (!$group) return;

        $ids = $group['items']->pluck('cart_item_id')->toArray();

        if ($value) {
            $this->selectedItems = array_values(array_unique(array_merge($this->selectedItems, $ids)));
        } else {
            $this->selectedItems = array_values(array_diff($this->selectedItems, $ids));
        }
    }

    public function updateQuantity(string $cartItemId, int $quantity): void
    {
        app(CartService::class)->updateQuantity($cartItemId, $quantity);
        unset($this->cartItems, $this->groupedCartItems);
    }

    public function removeItem(string $cartItemId): void
    {
        app(CartService::class)->remove($cartItemId);
        
        $this->selectedItems = array_values(array_diff($this->selectedItems, [$cartItemId]));
        
        unset($this->cartItems, $this->groupedCartItems);
    }

    public function proceedToCheckout()
    {
        if (empty($this->selectedItems)) {
            session()->flash('error', 'Please select at least one item to checkout.');
            return;
        }

        $selectedItems = $this->cartItems
            ->filter(fn($item) => in_array($item['cart_item_id'], $this->selectedItems))
            ->values()
            ->toArray();

        session()->put('checkout_selected_items', $selectedItems);

        return redirect()->route('customer.checkout');
    }
};