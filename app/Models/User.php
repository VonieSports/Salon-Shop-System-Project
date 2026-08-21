<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Tenant;
use App\Observers\UserObserver;
use App\Traits\HasGender;
use App\Traits\OnlineStatusTrait;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable([
    'name',
    'gender',
    'birth_date',
    'email',
    'phone',
    'address',
    'bio',
    'avatar',
    'cover_photo',
    'password',
    'is_active',
    'last_login_at',
    'last_logout_at',
    'last_activity_at',
    'email_verified_at',
])]
#[Hidden(['password', 'remember_token'])] #[ObservedBy([UserObserver::class])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles, OnlineStatusTrait, HasGender;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at'     => 'datetime',
            'last_logout_at'    => 'datetime',
            'last_activity_at'  => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
            'birth_date'        => 'date',
        ];
    }
    

    public function tenant(): HasOne
    {
        return $this->hasOne(Tenant::class);
    }
 
    public function customerProfile(): HasOne
    {
        return $this->hasOne(Customer::class);
    }

    public function employeeProfile(): HasOne
    {
        return $this->hasOne(Employee::class);
    }

    public function tenantsWithAccess(): BelongsToMany
{
    return $this->belongsToMany(Tenant::class, 'tenant_users')->withPivot('role')->withTimestamps();
}
 
}
