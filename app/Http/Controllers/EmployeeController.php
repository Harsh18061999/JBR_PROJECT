<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\EmployeeRepositoryInterface;
use App\DataTables\EmployeeDataTable;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;
use File;
use App\Models\JobCategory;

class EmployeeController extends Controller
{
    private EmployeeRepositoryInterface $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository) 
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function index(EmployeeDataTable $dataTable)
    {
        $jobCategory = JobCategory::get();
        $employee = Employee::get();
        return $dataTable->render('content.employee.index',compact('jobCategory','employee'));
    }

    public function create()
    {
        $jobCategory = JobCategory::get();
        return view('content.employee.create',compact('jobCategory'));
    }

    public function store(Request $request) 
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:employees,email',
            'countryCode' => 'required',
            'contact_number' => 'required|unique:employees,contact_number',
            'date_of_birth' => 'required',
            'job' => 'required'
            // 'licence' => 'required',
        ]);

        $filename = '';
        if($request->has('lincense')) {
            $uploadedFile = $request->file('lincense');
            $filename = uniqid(). '.' .File::extension($uploadedFile->getClientOriginalName());
            Storage::disk('local')->putFileAs(
              'public/assets',
              $uploadedFile,
              $filename
            );
        }

        $data['filename'] = $filename;
        $request->merge($data);
    
        $employees = $this->employeeRepository->createEmployee($request->all());

        return redirect()->route('employee.index')
        ->with('success', 'Record created successfully.');

    }

    public function edit(Employee $employee)
    {
        $jobCategory = JobCategory::get();
        
        return view('content.employee.edit', compact('employee','jobCategory'));
    }

    public function update(Request $request)
    {
        $employeeId = $request->route('id');
        $employee = Employee::findOrFail($employeeId);
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'countryCode' => 'required',
            'email' => 'required',
            'contact_number' => 'required',
            'date_of_birth' => 'required',
            'job' => 'required'
            // 'licence' => 'required',
        ]);

        $filename = $employee->lincense;
        if($request->has('lincense')) {
            if(Storage::exists('public/assets/'.$employee->lincense)){
                Storage::delete('public/assets/'.$employee->lincense);
            }
            $uploadedFile = $request->file('lincense');
            $filename = uniqid(). '.' .File::extension($uploadedFile->getClientOriginalName());
            Storage::disk('local')->putFileAs(
              'public/assets',
              $uploadedFile,
              $filename
            );
        }

        $data['filename'] = $filename;
        $request->merge($data);

        $orderDetails = $request->only([
            'first_name',
            'last_name',
            'email',
            'contact_number',
            'countryCode',
            'date_of_birth',
            'job',
            'filename'
        ]);

        $this->employeeRepository->updateEmployee($employeeId,$orderDetails);

        return redirect()->route('employee.index')
            ->with('success', 'Employee updated successfully');
    }

    public function destory($id){
        $employee = Employee::findOrFail($id);
        if(Storage::exists('public/assets/'.$employee->lincense)){
            Storage::delete('public/assets/'.$employee->lincense);
        }
        $this->employeeRepository->deleteEmployee($id);

        return true;
    }

    public function statusUpdate($id,Request $request){
        $employee = Employee::where('id',$id)->first();
        if($employee){
            $employee->update([
                'status' => $request->status
            ]);
            $response['success'] = true;
            $response['message'] = 'Employee Has Been Blocked.';  
        }else{
            $response['success'] = false;
            $response['message'] = 'Selected Record Not Found.';  

        }
        return $response;
    }

    public function unBlock($id){
        $employee = Employee::where('id',$id)->first();
        if($employee){
            $employee->update([
                'status' => '0'
            ]);
            $response['success'] = true;
            $response['message'] = 'Employee Has Been UnBlocked.';  
        }else{
            $response['success'] = false;
            $response['message'] = 'Selected Record Not Found.';
        }
        return $response;
    }
}
