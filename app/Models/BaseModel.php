<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BaseModel extends Model
{
    protected $hidden = ['id'];
    protected $guarded = ['id'];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    protected static function boot(): void
    {
        parent::boot();
        static::creating(fn ($model) => $model->uuid = Str::uuid());
    }

    public function findIdByUuid(string $uuid)
    {
        return $this->select('id')->where('uuid', $uuid)->firstOrFail()->id;
    }

    public function getCreatedAtAttribute(string $value): string
    {
        return date('d/m/Y H:i:s', strtotime($value));
    }
}
