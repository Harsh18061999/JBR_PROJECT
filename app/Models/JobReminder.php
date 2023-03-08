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
        'reminder_date'
    ];
}