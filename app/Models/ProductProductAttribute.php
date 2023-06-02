<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductProductAttribute extends Model
{
    use HasFactory;

    protected $table = 'product_product_attribute';

    use HasFactory;
    protected $fillable = [
        'product_id',
        'product_attribute_id',
        ];
}
