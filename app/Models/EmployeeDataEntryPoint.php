<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDataEntryPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'sin',
        'line_1',
        'line_2',
        'country',
        'provience',
        'city_id',
        'postal_code',
        'transit_number',
        'institution_number',
        'account_number',
        'personal_identification',
    ];

    public function country_title(){
        return $this->hasOne(Country::class,'id','country');
    }

    public function provience_title(){
        return $this->hasOne(Provience::class,'id','provience');
    }

    public function city_title(){
        return $this->hasOne(City::class,'id','city_id');
    }

    public function employee_title(){
        return $this->hasOne(Employee::class,'id','employee_id');
    }
}
