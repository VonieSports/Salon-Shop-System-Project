<?php

namespace App\Models;

use App\BusinessHoursTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
     use BusinessHoursTrait;
     
      protected $fillable = [
        'user_id',
        'name',
        'slug',
        'phone',
        'email',
        'address',
        'logo',
        'is_active',
        'business_setup_completed',
        'business_hours',
        'business_type',
        'description',
        'verification_status',
        'rejection_reason',
        'submitted_at',
    ];

     protected $casts = [
        'is_active' => 'boolean',
        'business_setup_completed' => 'boolean',
        'business_hours' => 'array',
        'submitted_at' => 'datetime',
    ];


    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function productCategories(): HasMany
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function serviceCategories(): HasMany
    {
        return $this->hasMany(ServiceCategory::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function staff(): BelongsToMany
{
    return $this->belongsToMany(User::class, 'tenant_users')
        ->withPivot('role')
        ->withTimestamps();
}
}
