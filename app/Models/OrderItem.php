<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'product_name',
        'quantity', 'unit_price', 'unit_cost', 'subtotal',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'unit_cost'  => 'decimal:2',
        'subtotal'   => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
