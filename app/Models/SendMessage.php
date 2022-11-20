<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'job_request_id',
        'job_date',
        'message_status'
    ];
}
