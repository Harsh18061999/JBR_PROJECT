<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\JobRequest;

class JobStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:status';

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
        $jobRequest = JobRequest::where('status','!=','2')
            ->get();
        foreach($jobRequest as $job){
            $GmtTime = str_ireplace("gmt","",$job->supervisor->city->province->gmt_time);
            if($GmtTime > 0){
                $date1 = Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->addHours(abs((int)$GmtTime));
            }else{
                $date1 = Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->subHours(abs((int)$GmtTime));
            }
           
            $date2 = Carbon::createFromFormat('Y-m-d', $job->end_date);
            if($date1->gt($date2)){
                $job->update([
                    "status" => '2'
                ]);
            }
        }
    }
}
