<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Appointment extends Model
{
    protected $fillable = [
        'tenant_id',
        'customer_id',
        'employee_id',
        'service_id',
        'post_id',
        'order_id',
        'appointment_date',
        'queue_number',
        'status',
        'queued_at',
        'started_at',
        'completed_at',
        'notes',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'queue_number' => 'integer',
        'status' => AppointmentStatus::class,
        'queued_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // ===== Relationships =====

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'appointment_services')
                    ->withPivot('price')
                    ->withTimestamps();
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    //Helpers

    public function getTotalDurationAttribute(): int
    {
        return $this->services->sum('duration_minutes') ?? 0;
    }

    public function getTotalPriceAttribute(): float
    {
        return $this->services->sum(function ($service) {
            return $service->pivot->price ?? $service->price;
        });
    }

    public function isActive(): bool
    {
        return !in_array($this->status, [
            AppointmentStatus::COMPLETED,
            AppointmentStatus::CANCELED,
        ]);
    }

    public function scopeForDate(Builder $query, string $date): Builder
    {
        return $query->whereDate('appointment_date', $date);
    }

    public function scopeForEmployee(Builder $query, int $employeeId): Builder
    {
        return $query->where('employee_id', $employeeId);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNotIn('status', [
            AppointmentStatus::COMPLETED,
            AppointmentStatus::CANCELED,
        ]);
    }

    public function scopeQueued(Builder $query): Builder
    {
        return $query->where('status', AppointmentStatus::QUEUED);
    }

    public function scopeInProgress(Builder $query): Builder
    {
        return $query->where('status', AppointmentStatus::IN_PROGRESS);
    }
};