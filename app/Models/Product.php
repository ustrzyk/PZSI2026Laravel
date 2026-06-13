<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'Products';
    protected $primaryKey = 'Id';

    const CREATED_AT = 'CreationDateTime';
    const UPDATED_AT = 'EditDateTime';

    public function category()
    {
        // produkt należy do jednej kategorii
        return $this->belongsTo(Category::class, 'CategoryId', 'Id');
    }

    public function accessories()
    {
        // tutaj mam relacje wiele do wielu
        return $this->belongsToMany(
            Accessory::class,
            'ProductAccessories',
            'ProductId',
            'AccessoryId'
        );
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'ProductId', 'Id');
    }
}