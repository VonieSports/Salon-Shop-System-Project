<?php

namespace App\Builders;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Builder;

class OrderQueryBuilder extends Builder
{
    public function forTenant(int $tenantId): self
    {
        return $this->where('tenant_id', $tenantId);
    }

    public function byStatus(OrderStatus|string $status): self
    {
        return $this->where('status', $status instanceof OrderStatus ? $status->value : $status);
    }

    public function pending(): self
    {
        return $this->where('status', OrderStatus::PENDING->value);
    }
    public function confirmed(): self
    {
        return $this->where('status', OrderStatus::CONFIRMED->value);
    }
    public function preparing(): self
    {
        return $this->where('status', OrderStatus::PREPARING->value);
    }
    public function readyForPickup(): self
    {
        return $this->where('status', OrderStatus::READY_FOR_PICKUP->value);
    }
    public function completed(): self
    {
        return $this->where('status', OrderStatus::COMPLETED->value);
    }
    public function canceled(): self
    {
        return $this->where('status', OrderStatus::CANCELED->value);
    }
    public function notCanceled(): self
    {
        return $this->where('status', '!=', OrderStatus::CANCELED->value);
    }

    public function inStatusFlow(): self
    {
        return $this->whereIn('status', OrderStatus::getFlowValues());
    }

    public function byPaymentStatus(PaymentStatus|string $status): self
    {
        return $this->where('payment_status', $status instanceof PaymentStatus ? $status->value : $status);
    }

    public function paid(): self
    {
        return $this->where('payment_status', PaymentStatus::PAID->value);
    }
    public function unpaid(): self
    {
        return $this->where('payment_status', PaymentStatus::UNPAID->value);
    }
    public function refunded(): self
    {
        return $this->where('payment_status', PaymentStatus::REFUNDED->value);
    }
    public function partial(): self
    {
        return $this->where('payment_status', PaymentStatus::PARTIAL->value);
    }

    public function betweenDates($start, $end): self
    {
        return $this->whereBetween('created_at', [$start, $end]);
    }
    public function today(): self
    {
        return $this->whereDate('created_at', today());
    }
    public function thisWeek(): self
    {
        return $this->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }
    public function thisMonth(): self
    {
        return $this->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
    }
    public function thisYear(): self
    {
        return $this->whereBetween('created_at', [now()->startOfYear(), now()->endOfYear()]);
    }

    public function search(string $search): self
    {
        return $this->where(function ($q) use ($search) {
            $q->where('order_number', 'like', "%{$search}%")
                ->orWhereHas('customer', fn($qc) => $qc->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%"));
        });
    }

    public function withCustomer(): self
    {
        return $this->with(['customer:id,name,email,phone']);
    }
    public function withItems(): self
    {
        return $this->with(['items']);
    }
    public function withFullDetails(): self
    {
        return $this->with(['customer', 'items.product', 'paymentMethod']);
    }

    public function latestOrder(): self
    {
        return $this->latest();
    }
    public function oldestOrder(): self
    {
        return $this->oldest();
    }
    public function highestTotal(): self
    {
        return $this->orderByDesc('total');
    }
    public function lowestTotal(): self
    {
        return $this->orderBy('total');
    }
}
