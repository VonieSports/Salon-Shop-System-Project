<?php

namespace App\Services;

use App\Enums\PaymentStatus;
use App\Models\Order;

class OrderRulesService
{
    public function canCancel(Order $order): bool
    {
        if (!$order->status->canCancel()) {
            return false;
        }

        if ($order->payment_type === 'online' && $order->payment_status === PaymentStatus::PAID) {
            return false;
        }

        return true;
    }
}