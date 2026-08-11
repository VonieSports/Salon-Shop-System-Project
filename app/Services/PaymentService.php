<?php

namespace App\Services;

use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\PaymentMethod;

class PaymentService
{
    public function markPaid(Order $order): Order
    {
        if ($order->payment_status === PaymentStatus::PAID) {
            return $order;
        }

        $methodName = $order->payment_type === 'online' ? 'PayMongo' : 'Cash';

        $method = PaymentMethod::firstOrCreate([
            'tenant_id' => $order->tenant_id,
            'name' => $methodName,
        ]);

        $order->update([
            'payment_status' => PaymentStatus::PAID,
            'payment_method_id' => $order->payment_method_id ?? $method->id,
        ]);

        return $order->fresh();
    }
}