<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Support\DripEmailer;
use Carbon\Carbon;
use App\Models\JobConfirmation;
use App\Models\JobReminder;
use App\Models\JobRequest;
class JobRequestAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobrequest:details';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send alert message to employee.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $job_id = JobReminder::select('job_id')->whereDate('reminder_date',Carbon::now())
        ->pluck('job_id')->toArray();
        
        $jobRequest = JobRequest::whereNotIn('id',$job_id)->whereDate('job_date','<=',Carbon::now())
        ->whereDate('end_date','>=',Carbon::now())->where('status','1')->get();

        if($jobRequest){
            foreach($jobRequest as $k => $value){
                $this->jobStatus($value);
            }
     
        }
    }

    public function jobStatus($value){
        $GmtTime = str_ireplace("gmt","",$value->supervisor->city->province->gmt_time);
        if($GmtTime > 0){
            $currentTime = Carbon::now()->addHours(abs((int)$GmtTime));
        }else{
            $currentTime = Carbon::now()->subHours(abs((int)$GmtTime));
        }
        $date = $currentTime->format('g:i:A');
        $time = explode(":",$date);
        
        $job_time = explode(":",$value->start_time);
        if(($job_time[0]-1) <= $time[0] && $job_time[2] == $time[2]){
            foreach($value->jobConfirmation as $jobConfirmation){
                JobReminder::create([
                    "job_id" => $value->id,
                    'job_confirmations_id' => $jobConfirmation->id,
                    'job_reminder' => '1',
                    'time_sheet_reminder' => '0',
                    'reminder_date' => Carbon::now()
                ]);
                $first_name =  $jobConfirmation->employee->first_name;
                $last_name =  $jobConfirmation->employee->last_name;

                $message = " Hi, $first_name  Just reminding you about your scheduled job detailing at ⌚ ".$value->start_time .". today. \n";
    
                if(!!empty($value->supervisor->client)){
                    $message .= "Client Name : ". $value->supervisor->client->client_name ." \n";
                    $message .= "Address : ".$value->supervisor->client->client_address." \n";
                }
    
                if(!empty($value->job->supervisor)){
                    $message .= "Client Name : ". $value->supervisor->supervisor ." \n";
                    $message .= "Address : ".$value->supervisor->address ." \n";
                }
               
                $message .= "Start Date : ".$value->job_date." \n";
                $message .= "End Date : ".$value->end_date." \n";
                $message .= "Start Time : ".$value->start_time." \n";
                $message .= "End Time : ".$value->end_time." \n";
                
                $country_code = $jobConfirmation->employee->country->country_code;
                $number = '+'.$country_code.$jobConfirmation->employee->contact_number;
    
                $send_message = sendMessage($number,$message);  
            }
            
        }
    }
}
