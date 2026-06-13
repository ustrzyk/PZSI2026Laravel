<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'Users';
    protected $primaryKey = 'Id';

    const CREATED_AT = 'CreationDateTime';
    const UPDATED_AT = 'EditDateTime';

    public function orders()
    {
        // pobieram zamówienia tego użytkownika
        return $this->hasMany(Order::class, 'UserId', 'Id');
    }
}