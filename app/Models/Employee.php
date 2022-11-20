<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'contact_number',
        'date_of_birth',
        'lincense',
        'status',
        'job'
    ];

    public function jobCategory(){
        return $this->hasOne(JobCategory::class,'id','job');
    }

    public function message(){
        return $this->hasOne(SendMessage::class,'employee_id','id');
    }
}
