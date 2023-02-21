<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifyAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_number',
        'country_code',
        'token',
        'otp',
        'status'
    ];
}
