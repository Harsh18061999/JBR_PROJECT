<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class VerifyToken extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'token',
        'job_confirmation_id',
    ];
}
