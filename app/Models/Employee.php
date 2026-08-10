<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

  
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function schedules()
{
    return $this->hasMany(Schedule::class);
}
}
