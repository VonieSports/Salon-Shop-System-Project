<?php

namespace App\Support;

class PrivacyMasker
{
  
    public static function name(?string $name): string
    {
        if (!$name) return 'Guest';

        $parts = preg_split('/\s+/', trim($name));
        if (count($parts) === 1) return $parts[0];

        $last = array_pop($parts);
        return implode(' ', $parts) . ' ' . mb_strtoupper(mb_substr($last, 0, 1)) . '.';
    }

    public static function phone(?string $phone): string
    {
        if (!$phone) return '—';
        $len = strlen($phone);
        if ($len <= 6) return str_repeat('*', $len);
        return substr($phone, 0, 4) . str_repeat('*', $len - 7) . substr($phone, -3);
    }

    public static function email(?string $email): string
    {
        if (!$email || !str_contains($email, '@')) return '—';
        [$local, $domain] = explode('@', $email, 2);
        $visible = min(2, strlen($local));
        return substr($local, 0, $visible) . str_repeat('*', max(2, strlen($local) - $visible)) . '@' . $domain;
    }
}