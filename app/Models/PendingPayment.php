<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PendingPayment extends Model
{
    protected $fillable = ['user_id', 'paymongo_link_id', 'checkout_url', 'status', 'order_data', 'expires_at'];

    protected $casts = [
        'order_data' => 'array',
        'expires_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
