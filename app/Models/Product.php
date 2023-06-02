<?php

namespace App\Models;

use App\Models\ProductCategory;
use App\Models\ProductAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
    'name',
    'picture',
    'price',
    'discount_price',
    'stock',
    'vat',
    'description'
    ];

    use HasFactory;

    public function categories()
    {
        return $this->belongsToMany(ProductCategory::class, 'product_product_category', 'product_id', 'product_category_id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function attributevalues()
    {
        return $this->hasMany(AttributeValue::class);
    }

}
