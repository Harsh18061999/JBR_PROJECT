<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Support\DripEmailer;
use Carbon\Carbon;
use App\Models\JobConfirmation;
use App\Models\JobReminder;
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
        $job_c_id = JobReminder::whereDate('reminder_date',Carbon::now())->pluck('job_confirmations_id')->toArray();
        $job_confirmation = JobConfirmation::whereNotIn('id',$job_c_id)->with(['job.supervisor.client','employee'])->where('job_status','<','2')->get();
        if($job_confirmation){
            foreach($job_confirmation as $k => $value){
                
                $startDate = Carbon::createFromFormat('Y-m-d',$value->job->job_date);
                $endDate = Carbon::createFromFormat('Y-m-d', $value->job->end_date);

                $date1 = Carbon::createFromFormat('Y-m-d', $value->job->end_date);
                $date2 = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
        
                if(Carbon::now()->between($startDate, $endDate)){
                   $this->jobStatus($value);
                }else if($date1->eq($endDate)){
                    $this->jobStatus($value);
                }
            }
     
        }
    }

    public function jobStatus($value){
        $now = Carbon::now()->subRealHours(5);
        $date = $now->format('g:i:A');
        $time = explode(":",$date);
        
        $job_time = explode(":",$value->job->start_time);
        if(($job_time[0]-1) <= $time[0] && $job_time[2] == $time[2]){
            JobReminder::create([
                'job_confirmations_id' => $value->id,
                'job_reminder' => '1',
                'time_sheet_reminder' => '0',
                'reminder_date' => Carbon::now()
            ]);
            $first_name =  $value->employee->first_name;
            $last_name =  $value->employee->last_name;
            
            $message = " Hi, $first_name  Just reminding you about your scheduled job detailing at ⌚ ".$value->job->start_time .". today. \n";

            if(!!empty($value->job->supervisor->client)){
                $message .= "Client Name : ". $value->job->supervisor->client->client_name ." \n";
                $message .= "Address : ".$value->job->supervisor->client->client_address." \n";
            }

            if(!empty($value->job->supervisor)){
                $message .= "Client Name : ". $value->job->supervisor->supervisor ." \n";
                $message .= "Address : ".$value->job->supervisor->address ." \n";
            }

            if(!empty($value->job)){
                $message .= "Start Date : ".$value->job->job_date." \n";
                $message .= "End Date : ".$value->job->end_date." \n";
                $message .= "Start Time : ".$value->job->start_time." \n";
                $message .= "End Time : ".$value->job->end_time." \n";
            }

            $number = '+'.$value->employee->countryCode.$value->employee->contact_number;

            $send_message = sendMessage($number,$message);
        }
    }
}
