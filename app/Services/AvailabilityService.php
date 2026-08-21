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
        // Check if employees are already loaded (avoids N+1)
        if ($post->relationLoaded('employees')) {
            return $post->employees
                ->where('is_active', true)
                ->filter(fn($emp) => $emp->user !== null)
                ->values();
        }

        // Single query with eager loading
        return $post->employees()
            ->where('employees.is_active', true)
            ->whereHas('user')
            ->with(['user:id,name,avatar'])
            ->get();
    }

    public function employeeAvailability(Post $post, Carbon $date, ?Collection $employees = null): Collection
    {
        $employees = $employees ?? $this->eligibleEmployees($post);
        if ($employees->isEmpty()) {
            return collect();
        }

        $employeeIds = $employees->pluck('id')->toArray();

        // Single query for all appointments
        $appointmentsByEmployee = Appointment::whereIn('employee_id', $employeeIds)
            ->whereDate('appointment_date', $date)
            ->whereIn('status', [
                AppointmentStatus::QUEUED->value,
                AppointmentStatus::IN_PROGRESS->value,
            ])
            ->select('employee_id', 'status', 'queue_number', 'id')
            ->get()
            ->groupBy('employee_id');

        // Single query for all schedules
        $day = strtolower($date->format('l'));
        $schedulesByEmployee = Schedule::whereIn('employee_id', $employeeIds)
            ->where('day_of_week', $day)
            ->get()
            ->keyBy('employee_id');

        $isOpen = $this->isTenantOpen($post->tenant, $date);

        return $employees->map(function (Employee $employee) use (
            $appointmentsByEmployee,
            $schedulesByEmployee,
            $isOpen
        ) {
            $queue = $appointmentsByEmployee->get($employee->id, collect());
            $inProgress = $queue->firstWhere('status', AppointmentStatus::IN_PROGRESS->value);

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
        if (!$tenant) {
            return false;
        }

        $hours = $tenant->getBusinessHours();
        $day = strtolower($date->format('l'));

        return !empty($hours[$day]) && !($hours[$day]['closed'] ?? false);
    }
};