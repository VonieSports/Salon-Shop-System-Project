<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case PREPARING = 'preparing';
    case READY_FOR_PICKUP = 'ready_for_pickup';
    case COMPLETED = 'completed';
    case CANCELED = 'canceled';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'New Order',
            self::CONFIRMED => 'Confirmed',
            self::PREPARING => 'Preparing',
            self::READY_FOR_PICKUP => 'Ready for Pickup',
            self::COMPLETED => 'Picked Up',
            self::CANCELED => 'Canceled',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::PENDING => 'bg-amber-50 text-amber-700',
            self::CONFIRMED => 'bg-blue-50 text-blue-700',
            self::PREPARING => 'bg-slate-100 text-slate-700',
            self::READY_FOR_PICKUP => 'bg-teal-50 text-teal-700',
            self::COMPLETED => 'bg-emerald-50 text-emerald-700',
            self::CANCELED => 'bg-red-50 text-red-700',
        };
    }

    public function chartColor(): string
    {
        return match($this) {
            self::PENDING => '#F59E0B',
            self::CONFIRMED => '#3B82F6',
            self::PREPARING => '#64748B',
            self::READY_FOR_PICKUP => '#14B8A6',
            self::COMPLETED => '#10B981',
            self::CANCELED => '#EF4444',
        };
    }

    public function actionLabel(): ?string
    {
        return match ($this) {
            self::PENDING => 'Confirm Order',
            self::CONFIRMED => 'Start Preparing',
            self::PREPARING => 'Mark as Ready for Pickup',
            self::READY_FOR_PICKUP => 'Mark as Picked Up',
            default => null,
        };
    }

    public function canCancel(): bool
    {
        return in_array($this, [self::PENDING, self::CONFIRMED], true);
    }

    public function canMarkPaid(): bool
    {
        return in_array($this, [self::CONFIRMED, self::PREPARING, self::READY_FOR_PICKUP, self::COMPLETED], true);
    }

    public function getNextStatus(): ?self
    {
        $flow = self::getFlow();
        $i = array_search($this, $flow, true);
        return ($i !== false && isset($flow[$i + 1])) ? $flow[$i + 1] : null;
    }

    public static function getFlow(): array
    {
        return [self::PENDING, self::CONFIRMED, self::PREPARING, self::READY_FOR_PICKUP, self::COMPLETED];
    }

    public static function getFlowValues(): array
    {
        return array_map(fn ($s) => $s->value, self::getFlow());
    }

    public static function getAllLabels(): array
    {
        return array_reduce(self::cases(), fn ($c, $case) => $c + [$case->value => $case->label()], []);
    }

    public static function getAllBadgeClasses(): array
    {
        return array_reduce(self::cases(), fn ($c, $case) => $c + [$case->value => $case->badgeClass()], []);
    }

    public static function getAllChartColors(): array
    {
        return array_reduce(self::cases(), fn ($c, $case) => $c + [$case->value => $case->chartColor()], []);
    }
}