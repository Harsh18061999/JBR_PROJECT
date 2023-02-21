<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Supervisor extends Model
{
    use HasFactory ,  SoftDeletes;

    protected $fillable = [
        'client_id',
        'supervisor',
        'job',
        'address',
        'status'
    ];

    public function client(){
        return $this->hasOne(Client::class,'id','client_id');
    }

}
