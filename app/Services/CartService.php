<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CartService
{
    protected const SESSION_KEY = 'shopping_cart';
    protected const BUY_NOW_KEY = 'buy_now_item';

    public function items(): Collection
    {
        return collect(session()->get(self::SESSION_KEY, []));
    }

    public function add(array $item): string
    {
        $cart = session()->get(self::SESSION_KEY, []);

        foreach ($cart as $key => $existing) {
            if ($existing['product_id'] === $item['product_id'] && $existing['variant_id'] === $item['variant_id']) {
                $cart[$key]['quantity'] = min($cart[$key]['quantity'] + $item['quantity'], $item['max_stock'] ?? 999);
                session()->put(self::SESSION_KEY, $cart);
                return $key;
            }
        }

        $cartItemId = (string) Str::uuid();
        $item['cart_item_id'] = $cartItemId;
        $cart[$cartItemId] = $item;
        session()->put(self::SESSION_KEY, $cart);

        return $cartItemId;
    }

    public function updateQuantity(string $cartItemId, int $quantity): void
    {
        $cart = session()->get(self::SESSION_KEY, []);
        if (isset($cart[$cartItemId])) {
            $max = $cart[$cartItemId]['max_stock'] ?? 999;
            $cart[$cartItemId]['quantity'] = max(1, min($quantity, $max));
            session()->put(self::SESSION_KEY, $cart);
        }
    }

    public function remove(string $cartItemId): void
    {
        $cart = session()->get(self::SESSION_KEY, []);
        unset($cart[$cartItemId]);
        session()->put(self::SESSION_KEY, $cart);
    }

    public function clearTenant(int $tenantId): void
    {
        $cart = session()->get(self::SESSION_KEY, []);
        $cart = array_filter($cart, fn ($item) => $item['tenant_id'] !== $tenantId);
        session()->put(self::SESSION_KEY, $cart);
    }

    public function clearAll(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    public function count(): int
    {
        return (int) $this->items()->sum('quantity');
    }

    public function groupedByTenant(): Collection
    {
        return $this->items()->groupBy('tenant_id');
    }

    public function setBuyNowItem(array $item): void
    {
        $item['cart_item_id'] = 'buy_now';
        session()->put(self::BUY_NOW_KEY, $item);
    }

    public function getBuyNowItem(): ?array
    {
        return session()->get(self::BUY_NOW_KEY);
    }

    public function clearBuyNowItem(): void
    {
        session()->forget(self::BUY_NOW_KEY);
    }
    
    // =================================================================
    // FIX: Removed the duplicate getCart() method entirely. 
    // All read operations must use items() or groupedByTenant().
    // =================================================================
    
    // If you want a helper for the Livewire Cart component, use this:
    public function getCart(): Collection
    {
        return $this->items();
    }

    public function clearCart(): void
    {
        $this->clearAll();
    }
}