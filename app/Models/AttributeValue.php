<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    protected $table = 'attribute_values';

    use HasFactory;
    protected $fillable = [
        'value',
        'attribute_id',
        'product_id',
    ];

    public function Attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
