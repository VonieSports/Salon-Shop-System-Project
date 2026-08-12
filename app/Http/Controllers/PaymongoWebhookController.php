<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\PendingPayment;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Log;

class PaymongoWebhookController extends Controller
{
    public function handle(Request $request, PaymentService $paymentService)
    {
        Log::info('PayMongo Webhook Hit:', $request->all());

        $event = $request->input('data.attributes.type');
        $linkId = $request->input('data.attributes.data.id');

        if ($event !== 'link.payment.paid' || !$linkId) {
            return response()->json(['received' => true]);
        }

        $pending = PendingPayment::where('paymongo_link_id', $linkId)->first();

        if (!$pending) {
            Log::warning('PayMongo webhook: Unknown link ID', ['link_id' => $linkId]);
            return response()->json(['received' => true]);
        }

        $orderId = $pending->order_data['order_id'] ?? null;

        if ($orderId && $order = Order::find($orderId)) {
            
            Log::info('PayMongo webhook: Order found. Updating status to PAID.', ['order_id' => $order->id]);
          
            $paymentService->markPaid($order);
            
            $pending->update(['status' => 'paid']);

            Log::info('PayMongo webhook: Success! Order marked as paid.');

        } else {
            Log::error('PayMongo webhook: Order NOT FOUND', ['order_id' => $orderId]);
        }

        return response()->json(['received' => true]);
    }
}