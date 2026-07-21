<?php

namespace App;

trait BusinessHoursTrait
{
    public function getBusinessHours()
    {
        if ($this->business_hours) {
            return is_array($this->business_hours) 
                ? $this->business_hours 
                : json_decode($this->business_hours, true);
        }
        return [];
    }

    public function hasBusinessHours(): bool
    {
        $hours = $this->getBusinessHours();
        return !empty($hours);
    }

    public function getFormattedBusinessHours(): array
    {
        $hours = $this->getBusinessHours();
        
        if (!$hours) {
            return [];
        }

        $days = [
            'monday' => 'Monday',
            'tuesday' => 'Tuesday',
            'wednesday' => 'Wednesday',
            'thursday' => 'Thursday',
            'friday' => 'Friday',
            'saturday' => 'Saturday',
            'sunday' => 'Sunday'
        ];

        $formatted = [];
        foreach ($days as $key => $label) {
            if (isset($hours[$key])) {
                $formatted[$key] = [
                    'label' => $label,
                    'open' => $hours[$key]['open'] ?? null,
                    'close' => $hours[$key]['close'] ?? null,
                    'closed' => $hours[$key]['closed'] ?? false,
                ];
            } else {
                $formatted[$key] = [
                    'label' => $label,
                    'open' => null,
                    'close' => null,
                    'closed' => true,
                ];
            }
        }

        return $formatted;
    }
}
