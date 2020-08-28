<?php

namespace App\Models;

use Carbon\Carbon;

class Sales extends BaseModel
{
    const TABLE = 'sales';
    protected $table = self::TABLE;

    protected $dates = [
        'sold_at',
    ];

    public function customer()
    {
        return $this->hasOne(Customers::class, 'id', 'customer_id');
    }

    public function product()
    {
        return $this->hasOne(Products::class, 'id', 'product_id');
    }

    public function status()
    {
        return $this->hasOne(StatusSales::class, 'id', 'status_id');
    }

    public function setSoldAtAttribute($value)
    {
        $this->attributes['sold_at'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d H:i:s');
    }

    public function getSoldAtAttribute(string $value): string
    {
        return date('d/m/Y H\hi', strtotime($value));
    }

    public function getValueAttribute(): float
    {
        return $this->product->price * $this->quantity;
    }

    public function getTotalValueAttribute(): float
    {
        $value = $this->product->price * $this->quantity;
        return $this->discount ? $value - ($value * ($this->discount / 100)) : $value;
    }
}
