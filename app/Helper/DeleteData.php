<?php

namespace App\Helper;

class DeleteData {

    public function deleteJobRequest($id){
        $job = JobRequest::where('id',$id)->first();
        if($job){
            
        }
    }

    public  function jobConfirmation($job_id){
        jobConfirmation::where('job_id',$job_id)->first();
    }
}


?>