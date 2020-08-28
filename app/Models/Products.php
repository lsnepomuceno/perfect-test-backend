<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Image;

class Products extends BaseModel
{
    const TABLE = 'products';
    protected $table = self::TABLE;

    public function sale()
    {
        return $this->belongsTo(Sales::class, 'customer_id', 'id');
    }

    public function getImageB64Attribute(): ?string
    {
        if (Storage::exists($this->image)) {
            return Image::make(Storage::get($this->image))->encode('data-url')->getEncoded();
        }
        return null;
    }
}
