<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Service extends Model
{
    protected $fillable = [
        'tenant_id',
        'service_category_id',
        'name',
        'image',
        'price',
        'duration_minutes',
        'description',
        'is_active',
        'archived_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'duration_minutes' => 'integer',
        'is_active' => 'boolean',
        'archived_at' => 'datetime',
    ];

    // ===== Relationships =====

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'employee_services')
                    ->withPivot('tenant_id')
                    ->withTimestamps();
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function appointmentServices(): HasMany
    {
        return $this->hasMany(AppointmentService::class);
    }

    // ===== Helper Methods =====

    /**
     * Check if service is active
     */
    public function isActive(): bool
    {
        return $this->is_active && is_null($this->archived_at);
    }

    /**
     * Get active employees for this service
     */
    public function getActiveEmployees()
    {
        return $this->employees()
            ->where('employees.is_active', true)
            ->with(['user:id,name,avatar'])
            ->get();
    }

    // ===== Scopes =====

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->whereNull('archived_at');
    }

    public function scopeArchived(Builder $query): Builder
    {
        return $query->whereNotNull('archived_at');
    }
}