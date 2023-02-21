<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'client_name',
        'client_address',
        'supervisor',
        'job',
        'status'
    ];

    public function jobCategory(){
        return $this->hasOne(JobCategory::class,'id','job');
    }

    public function supervisour(){
        return $this->hasMany(Supervisor::class,'client_id','id');
    }
}
