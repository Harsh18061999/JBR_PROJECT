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
        $job_c_id = JobReminder::whereDate('reminder_date',Carbon::now())
        ->where('time_sheet_reminder','0')->pluck('job_confirmations_id')->toArray();
        $job_confirmation = JobConfirmation::whereIn('id',$job_c_id)->get();
        if($job_confirmation){
            foreach($job_confirmation as $k => $value){
               $this->jobStatus($value);
            }
        }
    }

    public function jobStatus($value){
        $GmtTime = str_ireplace("gmt","",$value->job->supervisor->city->province->gmt_time);
        if($GmtTime > 0){
            $currentTime = Carbon::now()->addHours(abs((int)$GmtTime));
        }else{
            $currentTime = Carbon::now()->subHours(abs((int)$GmtTime));
        }
        $date = $currentTime->format('g:i:A');
        $time = explode(":",$date);
        $job_time = explode(":",$value->job->end_time);
        if(($job_time[0]-1) <= $time[0] && $job_time[2] == $time[2]){
            JobReminder::where('job_confirmations_id',$value->id)->latest()->update([
                'time_sheet_reminder' => '1',
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
    
            $country_code = $value->employee->country->country_code;
            $number = '+'.$country_code.$value->employee->contact_number;
    
            $send_message = sendMessage($number,$message);
        }
    }
}
