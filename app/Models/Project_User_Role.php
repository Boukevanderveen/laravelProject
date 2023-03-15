<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project_User_Role extends Model
{
    use HasFactory;
    protected $table = 'project_user_role';
    protected $fillable = [
    'project_id',
    'user_id',
    'role_id',
    ];

    
}
