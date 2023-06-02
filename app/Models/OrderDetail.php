<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';

    use HasFactory;
    protected $fillable = [
        'quantity',
        'product_name',
        'product_price',
        'product_picture',
        'vat',
        'product_id',
        'order_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'orderdetails_id');
    }
}
