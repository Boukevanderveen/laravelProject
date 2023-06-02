<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adress extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_name',
        'name',
        'street',
        'house_number',
        'addition',
        'city',
        'zipcode',
        'phone_number',
        'email',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
