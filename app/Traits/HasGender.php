<?php

namespace App\Traits;

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

    public function getAgeAttribute(): ?int
    {
        return $this->birth_date?->age;
    }

    public static function getGenderOptions(): array
    {
        return [
            'male' => 'Male',
            'female' => 'Female',
            'other' => 'Other',
            'prefer_not_to_say' => 'Prefer not to say',
        ];
    }

    public function isMale(): bool
    {
        return $this->gender === 'male';
    }

    public function isFemale(): bool
    {
        return $this->gender === 'female';
    }

    public function scopeMale($query)
    {
        return $query->where('gender', 'male');
    }

    public function scopeFemale($query)
    {
        return $query->where('gender', 'female');
    }

    public function scopeGender($query, string $gender)
    {
        return $query->where('gender', $gender);
    }
}
