<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait RequiresTenant
{

    public function getTenant()
    {
        return Auth::user()?->tenant ?? null;
    }

    public function getTenantId(): ?int
    {
        return $this->getTenant()?->id;
    }

    protected function hasTenant(): bool
    {
        return auth()->check() && $this->getTenant() !== null;
    }

    protected function isMainTenantOwner(): bool
    {
        $tenant = $this->getTenant();
        return $tenant !== null && $tenant->isMainTenant();
    }

    protected function isTenantAdmin(?int $tenantId = null): bool
    {
        $user = Auth::user();
        $tenantId = $tenantId ?? $this->getTenantId();

        if (!$tenantId || !$user) {
            return false;
        }

        $tenant = $this->getTenant();
        if ($tenant && $tenant->id === $tenantId) {
            return true;
        }

        return $user->tenantsWithAccess()
            ->where('tenant_id', $tenantId)
            ->wherePivotIn('role', ['owner', 'admin'])
            ->exists();
    }

    protected function guardNoTenant(): bool
    {
        if ($this->hasTenant()) {
            return false;
        }

        foreach (get_object_vars($this) as $key => $value) {
            if (is_array($value)) {
                $this->$key = [];
            }
        }

        return true;
    }
};