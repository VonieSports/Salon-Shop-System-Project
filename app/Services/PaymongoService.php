<?php

namespace App\Services;

use App\Models\Order;
use App\Models\PendingPayment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymongoService
{
    
    protected ?string $secretKey;

    public function __construct()
    {
        $this->secretKey = config('services.paymongo.secret_key');
    }

    public function isConfigured(): bool
    {
        return filled($this->secretKey);
    }

    /**
     * @param  Order  $order
     * @param  string|null  $returnTo  Named route to redirect to after successful payment.
     *                                 Falls back to config('services.paymongo.default_redirect').
     */
    public function createCheckoutForOrder(Order $order, ?string $returnTo = null): string
    {
        $returnTo ??= config('services.paymongo.default_redirect');

        if (!$this->isConfigured() || config('services.paymongo.demo_mode')) {
            return $this->createDemoCheckout($order, $returnTo);
        }

        $response = Http::withBasicAuth($this->secretKey, '')
            ->acceptJson()
            ->post('https://api.paymongo.com/v1/links', [
                'data' => [
                    'attributes' => [
                        'amount' => (int) round($order->total * 100),
                        'description' => "Order #{$order->order_number}",
                        'remarks' => "tenant:{$order->tenant_id}",
                    ],
                ],
            ]);

        if ($response->failed()) {
            Log::error('PayMongo link creation failed', ['status' => $response->status()]);
            return $this->createDemoCheckout($order, $returnTo);
        }

        PendingPayment::create([
            'user_id' => $order->user_id,
            'paymongo_link_id' => $response->json('data.id'),
            'checkout_url' => $response->json('data.attributes.checkout_url'),
            'status' => 'pending',
            'return_to' => $returnTo,
            'order_data' => ['order_id' => $order->id],
            'expires_at' => now()->addHours(1),
        ]);

        return $response->json('data.attributes.checkout_url');
    }

    protected function createDemoCheckout(Order $order, string $returnTo): string
    {
        $linkId = 'demo_' . Str::uuid();

        PendingPayment::create([
            'user_id' => $order->user_id,
            'paymongo_link_id' => $linkId,
            'checkout_url' => route('customer.payment.demo', $linkId),
            'status' => 'pending',
            'return_to' => $returnTo,
            'order_data' => ['order_id' => $order->id],
            'expires_at' => now()->addHours(1),
        ]);

        return route('customer.payment.demo', $linkId);
    }
}