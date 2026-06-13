<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accessory extends Model
{
    protected $table = 'Accessories';
    protected $primaryKey = 'Id';

    const CREATED_AT = 'CreationDateTime';
    const UPDATED_AT = 'EditDateTime';

    public function products()
    {
        // akcesorium może pasować do wielu produktów
        return $this->belongsToMany(
            Product::class,
            'ProductAccessories',
            'AccessoryId',
            'ProductId'
        );
    }
}