<?php

namespace App;

trait OnlineStatusTrait
{
 public function getStatusAttribute(): array
    {

        if (!$this->last_login_at) {
            return [
                'status' => 'never_logged_in',
                'label' => 'Never Logged In',
                'badge_class' => 'bg-yellow-100 text-yellow-700',
                'dot_class' => 'bg-yellow-500',
                'is_online' => false,
            ];
        }

        $isOnline = false;
        
        if ($this->last_activity_at) {
            $isOnline = $this->last_activity_at->diffInMinutes(now()) < 5;
        }
        
        if (!$isOnline && $this->last_login_at && !$this->last_logout_at) {
            $isOnline = $this->last_login_at->diffInMinutes(now()) < 15;
        }
        
        if ($this->last_logout_at && $this->last_logout_at > $this->last_login_at) {
            $isOnline = false;
        }
        
        if ($isOnline) {
            return [
                'status' => 'online',
                'label' => 'Online Now',
                'badge_class' => 'bg-green-100 text-green-700',
                'dot_class' => 'bg-green-500 animate-pulse',
                'is_online' => true,
            ];
        }

        if ($this->last_logout_at && $this->last_logout_at > $this->last_login_at) {
            return [
                'status' => 'offline',
                'label' => 'Offline',
                'badge_class' => 'bg-gray-100 text-gray-500',
                'dot_class' => 'bg-gray-400',
                'is_online' => false,
            ];
        }

        return [
            'status' => 'offline',
            'label' => 'Offline',
            'badge_class' => 'bg-gray-100 text-gray-500',
            'dot_class' => 'bg-gray-400',
            'is_online' => false,
        ];
    }

    public function getIsOnlineAttribute(): bool
    {
        return $this->status['is_online'];
    }
}
