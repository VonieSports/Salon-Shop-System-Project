<?php

namespace App\Traits;

trait OnlineStatusTrait
{
    protected const ACTIVITY_THRESHOLD_MINUTES = 5;
    protected const LOGIN_GRACE_MINUTES = 15;

    public function getStatusAttribute(): array
    {
        if (!$this->last_login_at) {
            return $this->statusPayload('never_logged_in', 'Never Logged In', 'bg-yellow-100 text-yellow-700', 'bg-yellow-500', false);
        }

        if ($this->computeIsOnline()) {
            return $this->statusPayload('online', 'Online', 'bg-green-100 text-green-700', 'bg-green-500 animate-pulse', true);
        }

        return $this->statusPayload('offline', 'Offline', 'bg-gray-100 text-gray-500', 'bg-gray-400', false);
    }

    public function getIsOnlineAttribute(): bool
    {
        return $this->computeIsOnline();
    }

    protected function computeIsOnline(): bool
    {
        if (!$this->last_login_at) {
            return false;
        }

        if ($this->last_logout_at && $this->last_logout_at->gt($this->last_login_at)) {
            return false;
        }

        if ($this->last_activity_at) {
            return $this->last_activity_at->diffInMinutes(now()) < self::ACTIVITY_THRESHOLD_MINUTES;
        }

        return $this->last_login_at->diffInMinutes(now()) < self::LOGIN_GRACE_MINUTES;
    }

    protected function statusPayload(string $status, string $label, string $badgeClass, string $dotClass, bool $isOnline): array
    {
        return [
            'status' => $status,
            'label' => $label,
            'badge_class' => $badgeClass,
            'dot_class' => $dotClass,
            'is_online' => $isOnline,
        ];
    }

    public function scopeOnline($query)
    {
        return $query->whereNotNull('last_login_at')
            ->where(function ($q) {
                $q->where(function ($sub) {
                    $sub->whereNotNull('last_activity_at')
                        ->where('last_activity_at', '>=', now()->subMinutes(self::ACTIVITY_THRESHOLD_MINUTES));
                })->orWhere(function ($sub) {
                    $sub->whereNull('last_activity_at')
                        ->whereNull('last_logout_at')
                        ->where('last_login_at', '>=', now()->subMinutes(self::LOGIN_GRACE_MINUTES));
                });
            })
            ->where(function ($q) {
                $q->whereNull('last_logout_at')
                  ->orWhereColumn('last_logout_at', '<=', 'last_login_at');
            });
    }

    public function scopeOffline($query)
    {
        return $query->whereNotNull('last_login_at')
            ->whereNot(fn ($q) => $q->online());
    }

    public function scopeNeverLoggedIn($query)
    {
        return $query->whereNull('last_login_at');
    }
}
