<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobReminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_confirmations_id',
        'job_reminder',
        'time_sheet_reminder',
        'reminder_date',
        'job_id'
    ];

    public function job(){
        return $this->belongsTo(JobRequest::class,'job_id');
    }

    public function jobConfirmarion(){
        return $this->belongsTo(JobRequest::class,'job_id');
    }
}
