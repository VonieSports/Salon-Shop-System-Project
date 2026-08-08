<?php

namespace App\Traits;

trait HasVerificationStatus
{
     public function isApproved(): bool
    {
        return $this->verification_status === 'approved';
    }

    public function isPendingApproval(): bool
    {
        return $this->verification_status === 'pending';
    }

    public function isRejected(): bool
    {
        return $this->verification_status === 'rejected';
    }
}
