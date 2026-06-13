<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'OrderItems';
    protected $primaryKey = 'Id';

    const CREATED_AT = 'CreationDateTime';
    const UPDATED_AT = 'EditDateTime';

    public function order()
    {
        // pozycja należy do zamówienia
        return $this->belongsTo(Order::class, 'OrderId', 'Id');
    }

    public function product()
    {
        // pozycja zamówienia ma jeden produkt
        return $this->belongsTo(Product::class, 'ProductId', 'Id');
    }
}