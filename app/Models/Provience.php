<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Provience extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'country_id',
        'provience_name'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }   
}
