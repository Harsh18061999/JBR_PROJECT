<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class EmployeeTimeSheet extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'job_confirmations_id',
        'start_time',
        'break_time',
        'end_time',
        'job_date',
        'status',
        're_allocation_id'
    ];
}
