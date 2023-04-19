<?php

namespace App\Models;

use App\Models\ProductCategory;
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
        return $this->belongsToMany(ProductCategory::class);
    }

}
