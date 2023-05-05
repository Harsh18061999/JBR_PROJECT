<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReaAllocate extends Model
{
    use HasFactory;

    protected $fillable = [
        "employee_id",
        "job_id",
        "re_allocate_date"
    ];

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
