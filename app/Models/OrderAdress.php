<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAdress extends Model
{
    protected $table = 'order_adresses';
    protected $fillable = [
        'order_id',
        'company_name',
        'name',
        'street',
        'house_number',
        'addition',
        'city',
        'zipcode',
        'phone_number',
        'type',
        'email',
    ];

    use HasFactory;
}
