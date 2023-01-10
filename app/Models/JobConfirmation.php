<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobConfirmation extends Model
{
    use HasFactory;

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
}
