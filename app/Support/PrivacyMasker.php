<?php

namespace App\Support;

class PrivacyMasker
{
    public static function name(?string $name): string
    {
        if (!$name || trim($name) === '') {
            return 'Guest';
        }

        $words = preg_split('/\s+/', trim($name));

        return implode(' ', array_map([self::class, 'maskWord'], $words));
    }

    protected static function maskWord(string $word): string
    {
        $length = mb_strlen($word);

        if ($length <= 1) return $word;
        if ($length === 2) return mb_substr($word, 0, 1) . '*';

        return mb_substr($word, 0, 1)
            . str_repeat('*', $length - 2)
            . mb_substr($word, -1);
    }

    public static function phone(?string $phone): string
    {
        if (!$phone) return '—';
        $digits = preg_replace('/\D/', '', $phone);
        $len = strlen($digits);
        if ($len <= 4) return str_repeat('*', $len);
        return substr($digits, 0, 2) . str_repeat('*', $len - 5) . substr($digits, -3);
    }

    public static function email(?string $email): string
    {
        if (!$email || !str_contains($email, '@')) return '—';
        [$local, $domain] = explode('@', $email, 2);
        $visible = min(2, strlen($local));
        return substr($local, 0, $visible) . str_repeat('*', max(2, strlen($local) - $visible)) . '@' . $domain;
    }

    public static function avatarInitial(?string $name): string
    {
        return strtoupper(mb_substr(trim((string) $name) ?: 'U', 0, 1));
    }
}