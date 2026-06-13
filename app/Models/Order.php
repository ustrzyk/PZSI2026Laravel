<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'Orders';
    protected $primaryKey = 'Id';

    const CREATED_AT = 'CreationDateTime';
    const UPDATED_AT = 'EditDateTime';

    public function user()
    {
        // zamówienie należy do użytkownika
        return $this->belongsTo(User::class, 'UserId', 'Id');
    }

    public function items()
    {
        // zamówienie ma wiele aktywnych pozycji
        return $this->hasMany(OrderItem::class, 'OrderId', 'Id')
            ->where('IsActive', 1);
    }
}