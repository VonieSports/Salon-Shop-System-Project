<?php

namespace App\Services;

use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Log;

class PaymentService
{
 public function markPaid(Order $order, ?string $channel = null): Order
    {
        if ($order->payment_status === PaymentStatus::PAID) {
            Log::info('Payment: order already paid, skipping.', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
            ]);
            return $order;
        }

        $methodName = match (true) {
            $order->payment_type !== 'online' => 'Cash',
            $channel === 'gcash' => 'GCash',
            $channel === 'maya' => 'Maya',
            $channel === 'qrph' => 'QRPh',
            default => 'PayMongo',
        };

        Log::info('Payment: resolving payment method.', [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'payment_type' => $order->payment_type,
            'channel_received' => $channel,
            'resolved_method' => $methodName,
        ]);

        $method = PaymentMethod::firstOrCreate([
            'tenant_id' => $order->tenant_id,
            'name' => $methodName,
        ]);

        $order->update([
            'payment_status' => PaymentStatus::PAID,
            'payment_method_id' => $order->payment_method_id ?? $method->id,
        ]);

        Log::info('Payment: order marked as paid.', [
            'order_id' => $order->id,
            'payment_method_id' => $method->id,
            'payment_method_name' => $method->name,
        ]);

        return $order->fresh();
    }
}