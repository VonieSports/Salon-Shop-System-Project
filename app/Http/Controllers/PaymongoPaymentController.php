<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PendingPayment;
use App\Services\PaymentService;
use App\Services\PaymongoService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PaymongoPaymentController extends Controller
{
     public function checkout(Order $order, PaymongoService $paymongo)
    {
        abort_unless($order->user_id === Auth::id(), 404);

        if ($order->payment_status->isPaid()) {
            return redirect()->route('customer.track_order', $order)->with('success', 'This order is already paid.');
        }

        return redirect()->away($paymongo->createCheckoutForOrder($order));
    }

    public function demoCheckout(string $linkId)
    {
        $pending = PendingPayment::where('paymongo_link_id', $linkId)->firstOrFail();
        $order = Order::findOrFail($pending->order_data['order_id']);

        return redirect()->route('customer.payment_demo', compact('pending', 'order'));
    }

    public function demoConfirm(string $linkId, PaymentService $paymentService)
    {
        $pending = PendingPayment::where('paymongo_link_id', $linkId)->firstOrFail();
        $order = Order::findOrFail($pending->order_data['order_id']);

        $paymentService->markPaid($order);
        $pending->update(['status' => 'paid']);

        return redirect()->route('customer.track_order', $order)->with('success', 'Payment received! Your order is now paid.');
    }
}
