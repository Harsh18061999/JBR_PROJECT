<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeTimeSheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_confirmations_id',
        'start_time',
        'break_time',
        'end_time',
        'job_date',
        'status'
    ];
}
