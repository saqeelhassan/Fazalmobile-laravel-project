<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'description', 'short_description',
        'price', 'sale_price', 'cost_price', 'sku', 'stock', 'category',
        'brand', 'image', 'gallery', 'status',
        'is_featured', 'is_on_sale', 'created_by',
    ];

    protected $casts = [
        'gallery'     => 'array',
        'is_featured' => 'boolean',
        'is_on_sale'  => 'boolean',
        'price'       => 'decimal:2',
        'sale_price'  => 'decimal:2',
        'cost_price'  => 'decimal:2',
    ];

    public function inventoryTransactions()
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public static function categories(): array
    {
        return ['Smart Watches', 'Games', 'Airbuds', 'Cables', 'Projector', 'Charger', 'Cooling Fan'];
    }

    public function scopeVisible($query)
    {
        return $query->whereIn('status', ['active', 'out_of_stock']);
    }
}
