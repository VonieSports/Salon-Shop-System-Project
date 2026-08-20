<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PendingPayment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class PaymongoWebhookController extends Controller
{
    public function handle(Request $request, PaymentService $paymentService)
    {
        if (! $this->hasValidSignature($request)) {
            Log::warning('PayMongo webhook: invalid or missing signature. Request rejected.');
            return response()->json(['error' => 'invalid signature'], Response::HTTP_UNAUTHORIZED);
        }

        $event = $request->input('data.attributes.type');
        $linkId = $request->input('data.attributes.data.id');

        Log::info('PayMongo webhook received', ['event' => $event, 'link_id' => $linkId]);

        if ($event !== 'link.payment.paid' || !$linkId) {
            return response()->json(['received' => true]);
        }

        $pending = PendingPayment::where('paymongo_link_id', $linkId)->first();

        if (!$pending) {
            Log::warning('PayMongo webhook: unknown link ID', ['link_id' => $linkId]);
            return response()->json(['received' => true]);
        }

        $orderId = $pending->order_data['order_id'] ?? null;

        if ($orderId && $order = Order::find($orderId)) {
            $paymentService->markPaid($order);
            $pending->update(['status' => 'paid']);
            Log::info('PayMongo webhook: order marked paid', ['order_id' => $order->id]);
        } else {
            Log::error('PayMongo webhook: order not found', ['order_id' => $orderId]);
        }

        return response()->json(['received' => true]);
    }

    /**
     * Verifies PayMongo's HMAC-SHA256 webhook signature so only PayMongo
     * (not a random POST from anywhere) can mark an order as paid.
     * https://developers.paymongo.com/docs/webhooks#verifying-webhook-signatures
     */
    protected function hasValidSignature(Request $request): bool
    {
        $secret = config('services.paymongo.webhook_secret');

        // No secret configured yet (pure local demo) — only allow outside production.
        if (blank($secret)) {
            return app()->environment(['local', 'testing']);
        }

        $header = $request->header('Paymongo-Signature');
        if (blank($header)) {
            return false;
        }

        $parts = collect(explode(',', $header))->mapWithKeys(function ($part) {
            [$key, $value] = array_pad(explode('=', $part, 2), 2, null);
            return [$key => $value];
        });

        $timestamp = $parts->get('t');
        $signature = app()->environment('production') ? $parts->get('li') : $parts->get('te');

        if (!$timestamp || !$signature) {
            return false;
        }

        $expected = hash_hmac('sha256', $timestamp . '.' . $request->getContent(), $secret);

        return hash_equals($expected, $signature);
    }
}