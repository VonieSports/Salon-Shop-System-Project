<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PendingPayment;
use App\Services\PaymentService;
use App\Services\PaymongoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymongoPaymentController extends Controller
{
    public function checkout(Order $order, PaymongoService $paymongo)
    {
        abort_unless($order->user_id === Auth::id(), 404);

        if ($order->payment_status->isPaid()) {
            return redirect()->route('customer.track_order', $order)->with('success', 'This order is already paid.');
        }

        return redirect()->away(
            $paymongo->createCheckoutForOrder($order, 'customer.track_order')
        );
    }

    public function demoCheckout(string $linkId)
    {
        $pending = PendingPayment::where('paymongo_link_id', $linkId)->firstOrFail();

        $orderId = $pending->order_data['order_id'] ?? null;
        abort_unless($orderId, 404, 'Order data missing for this payment link.');

        $order = Order::findOrFail($orderId);
        abort_unless($order->user_id === Auth::id(), 403);

        return view('pages.customer.⚡payment-demo.payment-demo', compact('pending', 'order'));
    }

  public function demoConfirm(Request $request, string $linkId, PaymentService $paymentService)
{
    $pending = PendingPayment::where('paymongo_link_id', $linkId)->firstOrFail();
    $order = Order::findOrFail($pending->order_data['order_id']);

    abort_unless($order->user_id === Auth::id(), 403);

    $channel = $request->input('channel', 'gcash');

    Log::channel('payments')->info('Payment: demo confirm submitted.', [
        'link_id' => $linkId,
        'order_id' => $order->id,
        'resolved_channel' => $channel,
    ]);

    $paymentService->markPaid($order, $channel);
    $pending->update(['status' => 'paid', 'channel' => $channel]);

    $routeName = $pending->return_to ?: config('services.paymongo.default_redirect');
    $redirectUrl = route($routeName, $order);

    if ($request->wantsJson()) {
        return response()->json([
            'success' => true,
            'redirect_url' => $redirectUrl,
        ]);
    }

    return redirect($redirectUrl)->with('success', 'Payment received! Your order is now paid.');
}
}