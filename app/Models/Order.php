<?php

namespace App\Models;

use App\Builders\OrderQueryBuilder;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
      protected $fillable = [
        'tenant_id', 'user_id', 'customer_id', 'payment_method_id',
        'order_number', 'type', 'status', 'payment_status', 'payment_type',
        'subtotal', 'discount', 'tax', 'total', 'notes',
        'confirmed_at', 'completed_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'confirmed_at' => 'datetime',
        'completed_at' => 'datetime',
        'status' => OrderStatus::class,
        'payment_status' => PaymentStatus::class,
    ];

    public function tenant(): BelongsTo 
    { 
        return $this->belongsTo(Tenant::class); 
    }
    
    public function user(): BelongsTo 
    { 
        return $this->belongsTo(User::class); 
    }
    
    public function customer(): BelongsTo 
    { 
        return $this->belongsTo(Customer::class); 
    }
    
    public function paymentMethod(): BelongsTo 
    { 
        return $this->belongsTo(PaymentMethod::class); 
    }
    
    public function items(): HasMany 
    { 
        return $this->hasMany(OrderItem::class); 
    }

    public function newEloquentBuilder($query): OrderQueryBuilder
    {
        return new OrderQueryBuilder($query);
    }
    
};
