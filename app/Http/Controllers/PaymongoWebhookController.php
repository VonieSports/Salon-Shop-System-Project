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
        $event = $request->input('data.attributes.type');
        $linkId = $request->input('data.attributes.data.id');

        if ($event !== 'link.payment.paid' || !$linkId) {
            return response()->json(['received' => true]);
        }

        $pending = PendingPayment::where('paymongo_link_id', $linkId)->first();
        if (!$pending) {
            Log::warning('PayMongo webhook: unknown link id', ['link_id' => $linkId]);
            return response()->json(['received' => true]);
        }

        if ($order = Order::find($pending->order_data['order_id'] ?? null)) {
            $paymentService->markPaid($order);
            $pending->update(['status' => 'paid']);
        }

        return response()->json(['received' => true]);
    }
}
