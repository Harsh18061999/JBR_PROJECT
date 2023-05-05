<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class JobRequest extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'supervisor_id',
        'job_id',
        'job_date',
        'end_date',
        'hireperiod',
        'start_time',
        'end_time',
        'no_of_employee',
        'status'
    ];

    public function jobCategory(){
        return $this->hasOne(JobCategory::class,'id','job_id');
    }

    public function supervisor(){
        return $this->hasOne(Supervisor::class,'id','supervisor_id');
    }

    public function jobConfirmation(){
        return $this->hasMany(JobConfirmation::class,'job_id','id');
    }

    public function employees(){
        return $this->hasManyThrough(
            Employee::class,
            JobConfirmation::class,
            'job_id', // Foreign key on the environments table...
            'id', // Foreign key on the deployments table...
            'id', // Local key on the projects table...
            'employee_id' // Local key on the environments table...
        );
    }

    public function leave(){
        return $this->hasMany(Leave::class,'job_id','id');
    }

    public function reallocate(){
        return $this->hasMany(ReaAllocate::class,'job_id','id');
    }
}
