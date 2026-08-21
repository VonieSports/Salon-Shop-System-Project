<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Employee extends Model
{
    protected $fillable = [
        'tenant_id',
        'user_id',
        'position',
        'commission_rate',
        'hired_at',
        'is_active',
    ];

    protected $casts = [
        'commission_rate' => 'decimal:2',
        'hired_at' => 'date',
        'is_active' => 'boolean',
    ];

    // ===== Relationships =====

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'employee_services')
                    ->withPivot('tenant_id')
                    ->withTimestamps();
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'employee_services', 'employee_id', 'service_id');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    // ===== Helper Methods =====

    /**
     * Get full name from user relation
     */
    public function getNameAttribute(): ?string
    {
        return $this->user?->name;
    }

    /**
     * Get avatar from user relation
     */
    public function getAvatarAttribute(): ?string
    {
        return $this->user?->avatar;
    }

    /**
     * Check if employee has a schedule for a specific day
     */
    public function hasScheduleForDay(string $day): bool
    {
        return $this->schedules()
            ->where('day_of_week', $day)
            ->where('is_active', true)
            ->exists();
    }

    /**
     * Get schedule for a specific day
     */
    public function getScheduleForDay(string $day)
    {
        return $this->schedules()
            ->where('day_of_week', $day)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Check if employee is assigned to a service
     */
    public function isAssignedToService(int $serviceId): bool
    {
        return $this->services()->where('service_id', $serviceId)->exists();
    }

    // ===== Scopes =====

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeForTenant(Builder $query, int $tenantId): Builder
    {
        return $query->where('tenant_id', $tenantId);
    }

    public function scopeWithUser(Builder $query): Builder
    {
        return $query->with(['user:id,name,avatar,email,phone']);
    }
}