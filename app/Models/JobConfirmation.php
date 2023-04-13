<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class JobConfirmation extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'employee_id',
        'job_id',
        'status'
    ];

    public function job(){
        return $this->hasOne(JobRequest::class,'id','job_id');
    }

    public function employee(){
        return $this->hasOne(Employee::class,'id','employee_id');
    }

    public function jobStatus(){
        return $this->hasOne(JobReminder::class)->last();
    }

    public function timeSheet(){
        return $this->hasMany(EmployeeTimeSheet::class,'job_confirmations_id');
    }
}
