<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';
    
    use HasFactory;
    protected $fillable = [
    'name',
    'description',
    'creator'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps()->withPivot(['role_id'])->using(ProjectUser::class);
    }
}
