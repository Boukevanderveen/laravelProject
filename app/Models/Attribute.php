<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = [
        'name',
        'type_id'
    ];
    use HasFactory;

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }
}
