<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemVariant extends Model
{
    protected $fillable = [
        'tenant_id',
        'product_id',
        'service_id',
        'attributes',
        'sku',
        'stock',
        'price_adjustment',
        'duration_adjustment',
        'image',
        'is_optional',
    ];

    protected $casts = [
        'attributes' => 'array',
        'price_adjustment' => 'decimal:2',
        'stock' => 'integer',
        'duration_adjustment' => 'integer',
        'is_optional' => 'boolean',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
