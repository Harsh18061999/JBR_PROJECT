<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class City extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'provience_id',
        'city_title'
    ];

    public function province()
    {
        return $this->belongsTo(Provience::class,'provience_id','id');
    }
}
