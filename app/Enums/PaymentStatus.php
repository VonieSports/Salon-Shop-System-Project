<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case UNPAID = 'unpaid';
    case PAID = 'paid';
    case REFUNDED = 'refunded';
    case PARTIAL = 'partial';

    public function label(): string
    {
        return match($this) {
            self::UNPAID => 'Unpaid',
            self::PAID => 'Paid',
            self::REFUNDED => 'Refunded',
            self::PARTIAL => 'Partial',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::UNPAID => 'bg-amber-50 text-amber-700',
            self::PAID => 'bg-emerald-50 text-emerald-700',
            self::REFUNDED => 'bg-red-50 text-red-700',
            self::PARTIAL => 'bg-blue-50 text-blue-700',
        };
    }

    public function isPaid(): bool
    {
        return $this === self::PAID;
    }

    public function isUnpaid(): bool
    {
        return $this === self::UNPAID;
    }

    public static function getAllLabels(): array
    {
        return array_reduce(self::cases(), function ($carry, $case) {
            $carry[$case->value] = $case->label();
            return $carry;
        }, []);
    }

    public static function getAllBadgeClasses(): array
    {
        return array_reduce(self::cases(), function ($carry, $case) {
            $carry[$case->value] = $case->badgeClass();
            return $carry;
        }, []);
    }
}