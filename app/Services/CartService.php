<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CartService
{
    protected const SESSION_KEY = 'shopping_cart';

    public function items(): Collection
    {
        return collect(session()->get(self::SESSION_KEY, []));
    }

    public function add(array $item): string
    {
        $cart = session()->get(self::SESSION_KEY, []);

        foreach ($cart as $key => $existing) {
            if ($existing['product_id'] === $item['product_id']
                && $existing['variant_id'] === $item['variant_id']) {
                $cart[$key]['quantity'] = min(
                    $cart[$key]['quantity'] + $item['quantity'],
                    $item['max_stock'] ?? 999
                );
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
}