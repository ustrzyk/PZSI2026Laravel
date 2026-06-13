<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'Categories';
    protected $primaryKey = 'Id';

    const CREATED_AT = 'CreationDateTime';
    const UPDATED_AT = 'EditDateTime';

    public function products()
    {
        // jedna kategoria ma wiele produktów
        return $this->hasMany(Product::class, 'CategoryId', 'Id');
    }
}