<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\JobCategoryRepositoryInterface;
use App\DataTables\JobCategoryDatatable;
use App\Models\JobCategory;
use Validator;

class JobCategoryController extends Controller
{
    private JobCategoryRepositoryInterface $jobCategoryRepository;

    public function __construct(JobCategoryRepositoryInterface $jobCategoryRepository) 
    {
        $this->jobCategoryRepository = $jobCategoryRepository;
    }

    public function index(JobCategoryDatatable $dataTable)
    {
        return $dataTable->render('content.jobcategory.index');
    }

    public function store(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'job_title' => 'required|unique:job_categories,job_title',
        ]);

        if($validator->fails()){
            $error_message = '';

            if(!empty($validator->errors())){
                foreach($validator->messages()->all() as $key => $value){
                    $error_message .= $value;
                }
            }

            $response['error'] = $error_message;
            return $response;    
        }

        $jobCategory = $this->jobCategoryRepository->createJobCategory($request->all());

        $response = [
            'success' => true,
            'message' => "JobCategory has been created successfully.",
        ];

        return $response;

    }

    public function edit(JobCategory $jobCategory)
    {
        $response = array();
        if(!$jobCategory){
            $response['success'] = false;
            $response['message'] = "You Selected Invalide Record.";
        }else{
            $response['success'] = true;
            $response['data'] = $jobCategory;
        }
        return $response;
    }

    public function update(Request $request)
    {
        $jobCategoryId = $request->route('id');

        $validator = Validator::make($request->all(), [
            'job_title' => 'required|unique:job_categories,job_title,'.$jobCategoryId,
        ]);

        if($validator->fails()){
            $error_message = '';

            if(!empty($validator->errors())){
                foreach($validator->messages()->all() as $key => $value){
                    $error_message .= $value;
                }
            }

            $response['error'] = $error_message;
            return $response;    
        }

        $orderDetails = $request->only([
            'job_title',
            'license_status'
        ]);

        $this->jobCategoryRepository->updateJobCategory($jobCategoryId,$orderDetails);

        $response = [
            'success' => true,
            'message' => "JobCategory has been updated successfully.",
        ];

        return $response;
    }

    public function destroy($id){

        $this->jobCategoryRepository->deleteJobCategory($id);

        return true;
    }

}
