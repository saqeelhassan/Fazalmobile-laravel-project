<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'user_id', 'label', 'full_name', 'phone', 'province', 'city', 'zone',
        'address_line', 'landmark', 'postal_code',
        'is_default_shipping', 'is_default_billing',
    ];

    protected $casts = [
        'is_default_shipping' => 'boolean',
        'is_default_billing'  => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
