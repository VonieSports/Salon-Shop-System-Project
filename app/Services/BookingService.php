<?php
// app/Services/BookingService.php

namespace App\Services;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Employee;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookingService
{
  
    public function queue(Post $post, Employee $employee, ?int $customerId, Carbon $date, ?int $orderId = null, ?string $notes = null): Appointment
    {
        return DB::transaction(function () use ($post, $employee, $customerId, $date, $orderId, $notes) {
            $nextNumber = Appointment::where('employee_id', $employee->id)
                ->whereDate('appointment_date', $date)
                ->lockForUpdate()
                ->max('queue_number');

            return Appointment::create([
                'tenant_id' => $post->tenant_id,
                'customer_id' => $customerId,
                'employee_id' => $employee->id,
                'service_id' => $post->inventory_id,
                'post_id' => $post->id,
                'order_id' => $orderId,
                'appointment_date' => $date->toDateString(),
                'queue_number' => ((int) $nextNumber) + 1,
                'status' => AppointmentStatus::QUEUED,
                'queued_at' => now(),
                'notes' => $notes,
            ]);
        });
    }

    public function start(Appointment $appointment): Appointment
    {
        if (!$appointment->status->canStart()) {
            throw new \RuntimeException('This appointment cannot be started from its current status.');
        }

        $appointment->update(['status' => AppointmentStatus::IN_PROGRESS, 'started_at' => now()]);
        return $appointment->fresh();
    }

    public function complete(Appointment $appointment): Appointment
    {
        if (!$appointment->status->canComplete()) {
            throw new \RuntimeException('This appointment cannot be completed from its current status.');
        }

        $appointment->update(['status' => AppointmentStatus::COMPLETED, 'completed_at' => now()]);
        return $appointment->fresh();
    }

    public function cancel(Appointment $appointment): Appointment
    {
        if (!$appointment->status->canCancel()) {
            throw new \RuntimeException('This appointment can no longer be canceled.');
        }

        $appointment->update(['status' => AppointmentStatus::CANCELED]);
        return $appointment->fresh();
    }
}