<?php

namespace App\Services;

use App\Models\User;

class ProfileCompletenessService
{
    protected const REQUIRED_FIELDS = [
        'phone' => 'Phone Number',
        'address' => 'Address',
    ];

    public function isComplete(User $user): bool
    {
        return empty($this->missingFields($user));
    }

    public function missingFields(User $user): array
    {
        $missing = [];

        foreach (self::REQUIRED_FIELDS as $field => $label) {
            if (blank($user->{$field})) {
                $missing[] = $label;
            }
        }

        return $missing;
    }
}