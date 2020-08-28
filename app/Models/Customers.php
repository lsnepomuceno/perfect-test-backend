<?php

namespace App\Models;

class Customers extends BaseModel
{
    const TABLE = 'customers';
    protected $table = self::TABLE;

    public function sales()
    {
        return $this->hasMany(Sales::class, 'customer_id', 'id');
    }
}
