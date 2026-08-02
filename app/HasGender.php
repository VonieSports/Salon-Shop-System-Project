<?php

namespace App;

trait HasGender
{
     public function getGenderLabelAttribute(): string
    {
        return match ($this->gender) {
            'male' => 'Male',
            'female' => 'Female',
            'other' => 'Other',
            'prefer_not_to_say' => 'Prefer not to say',
            default => 'Not specified',
        };
    }

    /**
     * Get the user's age.
     */
    public function getAgeAttribute(): ?int
    {
        return $this->birth_date?->age;
    }

    /**
     * Get all available gender options.
     */
    public static function getGenderOptions(): array
    {
        return [
            'male' => 'Male',
            'female' => 'Female',
            'other' => 'Other',
            'prefer_not_to_say' => 'Prefer not to say',
        ];
    }

    /**
     * Check if user is male.
     */
    public function isMale(): bool
    {
        return $this->gender === 'male';
    }

    /**
     * Check if user is female.
     */
    public function isFemale(): bool
    {
        return $this->gender === 'female';
    }

    /**
     * Scope a query to only include male users.
     */
    public function scopeMale($query)
    {
        return $query->where('gender', 'male');
    }

    /**
     * Scope a query to only include female users.
     */
    public function scopeFemale($query)
    {
        return $query->where('gender', 'female');
    }

    /**
     * Scope a query to only include users with a specific gender.
     */
    public function scopeGender($query, string $gender)
    {
        return $query->where('gender', $gender);
    }
}
