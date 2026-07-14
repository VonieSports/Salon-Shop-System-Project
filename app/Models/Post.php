<?php

namespace App\Models;

use App\Models\ProductCategory;
use App\Models\ServiceCategory;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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
        'status',
        'reject_reason',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
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

    public function inventory(): MorphTo
    {
        return $this->morphTo();
    }

    // Scopes
    public function scopeProduct($query)
    {
        return $query->where('type', 'product');
    }

    public function scopeService($query)
    {
        return $query->where('type', 'service');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
