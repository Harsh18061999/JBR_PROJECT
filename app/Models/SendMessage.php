<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class SendMessage extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'confirmation_id',
        'employee_id',
        'job_request_id',
        'job_date',
        'message_status',
        'is_reallocate'
    ];

    public function jobRequest(){
        return $this->hasOne(JobRequest::class,'id','job_request_id');
    }

    public function employee(){
        return $this->hasOne(Employee::class,'id','employee_id');
    }
}
