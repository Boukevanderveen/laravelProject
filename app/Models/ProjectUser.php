<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectUser extends Pivot
{
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
