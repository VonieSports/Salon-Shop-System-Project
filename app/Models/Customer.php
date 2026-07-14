<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
     protected $fillable = [
        'tenant_id',
        'user_id',
        'name',
        'phone',
        'email',
        'gender',
        'notes',
    ];

     protected $casts = [
        'tenant_id' => 'integer',
        'user_id' => 'integer',
    ];

  
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
