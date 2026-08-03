<?php

namespace App\Models;

use App\Models\InventoryLog;
use App\Models\ItemVariant;
use App\Models\OrderItem;
use App\Models\Post;
use App\Models\ProductCategory;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    protected $fillable = [
        'tenant_id',
        'product_category_id',
        'name',
        'image',
        'sku',
        'cost_price',
        'selling_price',
        'stock',
        'low_stock_alert',
        'notes',
        'additional_info', 
        'archived_at',
    ];

    protected $casts = [
        'cost_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'stock' => 'integer',
        'low_stock_alert' => 'integer',
        'archived_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'additional_info' => 'array',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function inventoryLogs(): HasMany
    {
        return $this->hasMany(InventoryLog::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ItemVariant::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'inventory_id')
            ->where('inventory_type', Product::class);
    }

     public function post(): HasOne
    {
        return $this->hasOne(Post::class, 'inventory_id')
            ->where('inventory_type', Product::class);
    }
    
    public function scopeAvailable($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock', '<=', 'low_stock_alert');
    }

    public function scopeArchived($query)
    {
        return $query->whereNotNull('archived_at');
    }

    public function scopeActive($query)
    {
        return $query->whereNull('archived_at');
    }

    protected function isLowStock(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->stock > 0 && $this->stock <= $this->low_stock_alert,
        );
    }

    protected function isOutOfStock(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->stock <= 0,
        );
    }
}