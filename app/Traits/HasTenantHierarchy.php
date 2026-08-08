<?php

namespace App\Traits;

trait HasTenantHierarchy
{
    public function isBranch(): bool
    {
        return !is_null($this->parent_tenant_id);
    }

    public function isMainTenant(): bool
    {
        return is_null($this->parent_tenant_id);
    }
}