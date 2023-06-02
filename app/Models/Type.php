<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = [
        'name'
    ];
    use HasFactory;

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attributes_types');
    }
}
