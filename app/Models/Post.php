<?php

namespace App\Models;

use App\Models\ProductCategory;
use App\Models\ServiceCategory;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
    protected $fillable = [
        'tenant_id',
        'created_by',
        'service_category_id',
        'product_category_id',
        'type',
        'inventory_type',
        'inventory_id',
        'name',
        'image',
        'price',
        'description',
        'additional_info',
        'status',
        'reject_reason',
        'archived_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'archived_at' => 'datetime',
        'additional_info' => 'array',
    ];

    // ===== Relationships =====
    
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function serviceCategory(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }

    /**
     * Get employees assigned to this service
     * Uses employee_services pivot table
     */
    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'employee_services', 'service_id', 'employee_id')
                    ->withPivot('tenant_id')
                    ->withTimestamps();
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function inventory(): MorphTo
    {
        return $this->morphTo('inventory', 'inventory_type', 'inventory_id');
    }

    // ===== Helper Methods =====
    
    /**
     * Check if this post is a service
     */
    public function isService(): bool
    {
        return $this->type === 'service';
    }

    /**
     * Check if this post is a product
     */
    public function isProduct(): bool
    {
        return $this->type === 'product';
    }

    /**
     * Check if post is published and not archived
     */
    public function isPublished(): bool
    {
        return $this->status === 'published' && is_null($this->archived_at);
    }

    /**
     * Get active employees with their user data
     */
    public function getActiveEmployees()
    {
        return $this->employees()
            ->where('employees.is_active', true)
            ->with(['user:id,name,avatar'])
            ->get();
    }

    /**
     * Check if service has any assigned employees
     */
    public function hasAssignedEmployees(): bool
    {
        return $this->employees()->where('employees.is_active', true)->exists();
    }

    // ===== Scopes =====

    public function scopeProduct(Builder $query): Builder
    {
        return $query->where('type', 'product');
    }

    public function scopeService(Builder $query): Builder
    {
        return $query->where('type', 'service');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')->whereNull('archived_at');
    }

    public function scopeDraft(Builder $query): Builder
    {
        return $query->where('status', 'draft');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeRejected(Builder $query): Builder
    {
        return $query->where('status', 'rejected');
    }
}