<?php

namespace App\Services;

use App\Models\Tenant;
use App\Models\Employee;
use App\Models\Schedule;
use Carbon\Carbon;

class ScheduleService
{

    public function isShopOpen(Tenant $tenant, string $day, ?string $time = null): bool
    {
        $hours = $tenant->getBusinessHours();
        
        if (empty($hours)) {
            return false;
        }

        if (!isset($hours[$day]) || ($hours[$day]['closed'] ?? false)) {
            return false;
        }

        if ($time) {
            $open = $hours[$day]['open'] ?? null;
            $close = $hours[$day]['close'] ?? null;

            if (!$open || !$close) {
                return false;
            }

            $inputTime = Carbon::createFromFormat('H:i', $time);
            $openTime = Carbon::createFromFormat('H:i', $open);
            $closeTime = Carbon::createFromFormat('H:i', $close);

            return $inputTime->between($openTime, $closeTime);
        }

        return true;
    }

    public function getEmployeeWeekSchedule(Employee $employee, Tenant $tenant): array
    {
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $tenantHours = $tenant->getBusinessHours();
        $employeeSchedules = Schedule::where('employee_id', $employee->id)->get()->keyBy('day_of_week');

        $week = [];

        foreach ($days as $day) {
            $isShopOpen = !empty($tenantHours) && isset($tenantHours[$day]) && !($tenantHours[$day]['closed'] ?? false);
            
            $week[$day] = [
                'label' => ucfirst($day),
                'shop_open' => $isShopOpen,
                'shop_hours' => $isShopOpen ? ($tenantHours[$day]['open'] ?? '') . ' - ' . ($tenantHours[$day]['close'] ?? '') : 'Closed',
                'employee_shift' => $employeeSchedules->get($day),
            ];
        }

        return $week;
    }
}