<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Http;
use App\Models\Employee;
use App\Models\JobRequest;
use App\Models\JobCategory;
use App\Models\Client;
class SendJobRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

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
        $job_request = JobRequest::where('job_message_status',0)->first();
        if($job_request){
            $employee = Employee::where('status','0')->limit(1)->get();
            foreach($employee as $k => $value){
                $client = Client::where('id',$job_request->client_id)->first();
                $job = JobCategory::where('id',$job_request->job_id)->first();
                $curl = curl_init();
                $curl1 = curl_init();

                $message = $client->client_name.' has been required to work for '.$job->job_title.' '.$client->supervisor;
                $number =  $value->contact_number;

                $message .= "\n Please select below link to fill the form \n".route('front.job_request');
                $link = route('front.job_request');
                
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.ultramsg.com/instance22910/messages/chat",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => "token=7iqilksxb8xyctsv&to=$number&body=$message&priority=10&referenceId=",
                    CURLOPT_HTTPHEADER => array(
                        "content-type: application/x-www-form-urlencoded"
                    ),
                ));

                
                curl_setopt_array($curl1, array(
                    CURLOPT_URL => "https://api.ultramsg.com/instance22910/messages/link",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => "token=7iqilksxb8xyctsv&to=$number&link=$link",
                    CURLOPT_HTTPHEADER => array(
                    "content-type: application/x-www-form-urlencoded"
                    ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    echo $response;
                }

                $response1 = curl_exec($curl1);
                $err1 = curl_error($curl1);

                curl_close($curl1);

                if ($err) {
                    echo "cURL Error #:" . $err1;
                } else {
                    echo $response1;
                }
            }
        }
    }
}
