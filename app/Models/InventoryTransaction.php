<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    protected $fillable = [
        'product_id', 'type', 'quantity', 'unit_cost', 'unit_price',
        'reference_number', 'notes', 'created_by',
    ];

    protected $casts = [
        'unit_cost'  => 'decimal:2',
        'unit_price' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
