<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_number', 'customer_name', 'customer_phone', 'customer_address', 'customer_email',
        'total_amount', 'delivery_charge', 'total_cost', 'profit',
        'status', 'payment_method', 'payment_status', 'stock_deducted',
        'notes', 'created_by',
    ];

    protected $casts = [
        'total_amount'    => 'decimal:2',
        'delivery_charge' => 'decimal:2',
        'total_cost'      => 'decimal:2',
        'profit'          => 'decimal:2',
        'stock_deducted'  => 'boolean',
    ];

    const COD_DELIVERY_CHARGE = 300;

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function generateOrderNumber(): string
    {
        $last = static::max('id') ?? 0;
        return 'ORD-' . date('Ymd') . '-' . str_pad($last + 1, 4, '0', STR_PAD_LEFT);
    }
}
