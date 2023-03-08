<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\JobConfirmation;
use App\Models\JobReminder;
use App\Models\VerifyToken;
use Illuminate\Support\Str;

class TimeSheetStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'time:sheet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $job_c_id = JobReminder::whereDate('reminder_date',Carbon::now()->subRealHours(5))->where('time_sheet_reminder','1')->pluck('job_confirmations_id')->toArray();
        $job_confirmation = JobConfirmation::whereNotIn('id',$job_c_id)->with(['job.supervisor.client','employee'])->with('job',function($q){
            $q->where('status','<','2');
        })->where('job_status','<','2')->get();
        if($job_confirmation){
            foreach($job_confirmation as $k => $value){
                if($value->job){
                    $startDate = Carbon::createFromFormat('Y-m-d',$value->job->job_date)->subRealHours(5);
                    $endDate = Carbon::createFromFormat('Y-m-d', $value->job->end_date)->subRealHours(5);
    
                    $date1 = Carbon::createFromFormat('Y-m-d', $value->job->end_date)->subRealHours(5);
                    $date2 = Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->subRealHours(5);
            
                    if(Carbon::now()->between($startDate, $endDate)){
                       $this->jobStatus($value);
                    }else if($date1->eq($endDate)){
                        $this->jobStatus($value);
                    }
                }
            }
     
        }
    }

    public function jobStatus($value){
        $now = Carbon::now()->subRealHours(5);
        $date = $now->format('g:i:A');
        $time = explode(":",$date);

        $job_time = explode(":",$value->job->end_time);
        if(($job_time[0]-1) <= $time[0] && $job_time[2] == $time[2]){
            echo $value->id;
            JobReminder::where('job_confirmations_id',$value->id)->latest()->update([
                'time_sheet_reminder' => '1',
                'reminder_date' => Carbon::now()
            ]);
            $first_name =  $value->employee->first_name;
            $last_name =  $value->employee->last_name;
            
            $token = Str::random(30);
            $message_status = VerifyToken::create([
                'token' => $token,
                'job_confirmation_id' => $value->id
            ]);
            
            $message = "Hello $first_name $last_name , \n";
            $message .= "Please uploade your time schedule below given link. \n";
            $message .= route('timeSheet',$token);
    
            $number = '+'.$value->employee->countryCode.$value->employee->contact_number;
    
            $send_message = sendMessage($number,$message);
        }
    }
}
