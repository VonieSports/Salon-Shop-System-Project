<?php

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Customer;
use App\Models\InventoryLog;
use App\Models\ItemVariant;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Tenant;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.customer')] class extends Component
{
    public string $paymentType = 'cash';
    public array $notes = [];

    protected function isBuyNowMode(): bool
    {
        return app(CartService::class)->getBuyNowItem() !== null;
    }

    #[Computed]
    public function groupedCart()
    {
        $checkoutItems = session('checkout_selected_items');
        
        $grouped = collect();
        
        if ($checkoutItems) {
            $grouped = collect($checkoutItems)->groupBy('tenant_id');
            session()->forget('checkout_selected_items');
        } else {
            $buyNowItem = app(CartService::class)->getBuyNowItem();

            $grouped = $buyNowItem
                ? collect([$buyNowItem['tenant_id'] => collect([$buyNowItem])])
                : app(CartService::class)->groupedByTenant();
        }

        if ($grouped->isEmpty()) return collect();

        $tenants = Tenant::whereIn('id', $grouped->keys())->select('id', 'name', 'logo')->get()->keyBy('id');

        return $grouped->map(fn ($items, $tenantId) => [
            'tenant' => $tenants->get((int) $tenantId),
            'items' => collect($items),
            'item_count' => collect($items)->sum('quantity'),
            'subtotal' => collect($items)->sum(fn ($i) => $i['unit_price'] * $i['quantity']),
        ]);
    }

    #[Computed] public function totalItems(): int { return (int) $this->groupedCart->sum('item_count'); }
    #[Computed] public function grandTotal(): float { return (float) $this->groupedCart->sum('subtotal'); }

    public function placeOrder()
    {
        $cartService = app(CartService::class);
        $grouped = $this->groupedCart; 

        if ($grouped->isEmpty()) {
            session()->flash('error', 'Your cart is empty.');
            return;
        }

        $user = Auth::user();
        $createdOrderIds = [];
        $buyNowMode = $this->isBuyNowMode();

        try {
            DB::transaction(function () use ($grouped, $user, &$createdOrderIds) {
                foreach ($grouped as $tenantId => $group) {
                    $tenantId = (int) $tenantId;
                    $items = $group['items'];

                    $customer = Customer::firstOrCreate(
                        ['tenant_id' => $tenantId, 'user_id' => $user->id],
                        ['name' => $user->name, 'email' => $user->email, 'phone' => $user->phone]
                    );

                    $subtotal = 0;
                    $lines = [];

                    foreach ($items as $item) {
                        $product = Product::where('tenant_id', $tenantId)->lockForUpdate()->findOrFail($item['product_id']);

                        $variant = null;
                        $availableStock = $product->stock;

                        if (!empty($item['variant_id'])) {
                            $variant = ItemVariant::where('tenant_id', $tenantId)->lockForUpdate()->findOrFail($item['variant_id']);
                            $availableStock = $variant->stock ?? 0;
                        }

                        if ($availableStock < $item['quantity']) {
                            throw new \RuntimeException("Insufficient stock for \"{$item['name']}\". Only {$availableStock} left.");
                        }

                        $lineSubtotal = $item['unit_price'] * $item['quantity'];
                        $subtotal += $lineSubtotal;
                        $lines[] = compact('product', 'variant', 'item', 'lineSubtotal');
                    }

                    $order = Order::create([
                        'tenant_id' => $tenantId,
                        'user_id' => $user->id,
                        'customer_id' => $customer->id,
                        'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                        'type' => 'product',
                        'status' => OrderStatus::PENDING,
                        'payment_status' => PaymentStatus::UNPAID,
                        'payment_type' => $this->paymentType,
                        'subtotal' => $subtotal,
                        'discount' => 0,
                        'tax' => 0,
                        'total' => $subtotal,
                        'notes' => $this->notes[$tenantId] ?? null,
                    ]);
                    $createdOrderIds[] = $order->id;

                    foreach ($lines as $line) {
                        ['product' => $product, 'variant' => $variant, 'item' => $item, 'lineSubtotal' => $lineSubtotal] = $line;

                        OrderItem::create([
                            'tenant_id' => $tenantId,
                            'order_id' => $order->id,
                            'product_id' => $product->id,
                            'item_type' => 'product',
                            'name' => $item['name'],
                            'price' => $item['unit_price'],
                            'quantity' => $item['quantity'],
                            'subtotal' => $lineSubtotal,
                            'variant_details' => !empty($item['variant_attributes']) ? json_encode($item['variant_attributes']) : null,
                        ]);

                        if ($variant) {
                            $stockBefore = $variant->stock ?? 0;
                            $stockAfter = max(0, $stockBefore - $item['quantity']);
                            $variant->update(['stock' => $stockAfter]);
                            $product->update(['stock' => ItemVariant::where('product_id', $product->id)->sum('stock')]);
                        } else {
                            $stockBefore = $product->stock;
                            $stockAfter = max(0, $stockBefore - $item['quantity']);
                            $product->update(['stock' => $stockAfter]);
                        }

                        InventoryLog::create([
                            'tenant_id' => $tenantId,
                            'product_id' => $product->id,
                            'type' => 'sale',
                            'quantity' => $item['quantity'],
                            'stock_before' => $stockBefore,
                            'stock_after' => $stockAfter,
                            'reference' => "Order #{$order->order_number}",
                        ]);
                    }
                }
            });

            if ($buyNowMode) {
                $cartService->clearBuyNowItem();
            } else {
                foreach ($grouped as $tenantId => $group) {
                    $cartService->clearTenant((int) $tenantId);
                }
            }

            if ($this->paymentType === 'online' && count($createdOrderIds) === 1) {
                return redirect()->route('customer.payment.paymongo', $createdOrderIds[0]);
            }

            if (count($createdOrderIds) > 1) {
                session()->flash('success', 'Your orders across ' . count($createdOrderIds) . ' shops have been placed!');
                return $this->redirect(route('customer.order_history'), navigate: true);
            }

            return $this->redirect(route('customer.track_order', $createdOrderIds[0]), navigate: true);

        } catch (\Throwable $e) {
            report($e);
            session()->flash('error', $e->getMessage() ?: 'Failed to place your order. Please try again.');
        }
    }
};