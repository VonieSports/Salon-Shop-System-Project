<?php

namespace App\Services;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Employee;
use App\Models\Post;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AvailabilityService
{
    public function eligibleEmployees(Post $post): Collection
    {
        $assigned = $post->employees()->where('employees.is_active', true)->with('user:id,name,avatar')->get();

        if ($assigned->isNotEmpty()) {
            return $assigned;
        }

        return $post->inventory
            ?->employees()
            ->where('employees.is_active', true)
            ->with('user:id,name,avatar')
            ->get() ?? collect();
    }

    public function employeeAvailability(Post $post, Carbon $date, ?Collection $employees = null): Collection
    {
        $employees = $employees ?? $this->eligibleEmployees($post);
        if ($employees->isEmpty()) return collect();

        $employeeIds = $employees->pluck('id');

        $appointmentsByEmployee = Appointment::whereIn('employee_id', $employeeIds)
            ->whereDate('appointment_date', $date)
            ->whereIn('status', [AppointmentStatus::QUEUED->value, AppointmentStatus::IN_PROGRESS->value])
            ->get()
            ->groupBy('employee_id');

        $day = strtolower($date->format('l'));
        $schedulesByEmployee = Schedule::whereIn('employee_id', $employeeIds)
            ->where('day_of_week', $day)
            ->get()
            ->keyBy('employee_id');

        $isOpen = $this->isTenantOpen($post->tenant, $date);

        return $employees->map(function (Employee $employee) use ($appointmentsByEmployee, $schedulesByEmployee, $isOpen) {
            $queue = $appointmentsByEmployee->get($employee->id, collect());
            $inProgress = $queue->firstWhere('status', AppointmentStatus::IN_PROGRESS);

            return [
                'employee' => $employee,
                'on_duty' => $isOpen && $schedulesByEmployee->has($employee->id),
                'is_busy' => (bool) $inProgress,
                'queue_length' => $queue->count(),
                'next_queue_number' => (int) $queue->max('queue_number') + 1,
            ];
        });
    }

    protected function isTenantOpen($tenant, Carbon $date): bool
    {
        $hours = $tenant->getBusinessHours();
        $day = strtolower($date->format('l'));

        return !empty($hours[$day]) && !($hours[$day]['closed'] ?? false);
    }
}