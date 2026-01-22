<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'vendor_id',
        'name',
        'description',
        'category',
        'price',
        'stock_quantity',
        'is_unlimited_stock',
        'status',
        'images',
        'approved_by',
        'approved_at',
        'rejection_reason',
        'views_count',
        'sales_count',
        'rating',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'images' => 'array',
        'approved_at' => 'datetime',
        'is_unlimited_stock' => 'boolean',
    ];

    /**
     * Get the vendor who owns this product
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Get the admin who approved this product
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the order items for this product
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Check if product is available for purchase
     */
    public function isAvailable(): bool
    {
        return $this->status === 'published' &&
               ($this->is_unlimited_stock || $this->stock_quantity > 0);
    }

    /**
     * Get the first image
     */
    public function getFirstImageAttribute(): ?string
    {
        $images = $this->images ?? [];
        return $images[0] ?? null;
    }
}
