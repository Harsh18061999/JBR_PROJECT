<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;


class Permission extends Authenticatable
{
    use HasRoles;

    protected $fillable = [
        'name'
    ];

}
