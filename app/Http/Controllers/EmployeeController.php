<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\EmployeeRepositoryInterface;
use App\DataTables\EmployeeDataTable;
use App\Models\Employee;
use App\Models\Country;
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
        $country_code = Country::get();
        return view('content.employee.create',compact('jobCategory','country_code'));
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
        $country = Country::where('id',$request->countryCode)->first();
        try {
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

            $first_name = $employees->first_name;
            $last_name = $employees->last_name;

            $message = "👏 Hello $first_name $last_name , \n";
            $message .= "Your account has been created successfully. \n";

            $number = '+' . $country->country_code . $employees->contact_number;
            sendMessage($number, $message);

            return redirect()->route('employee.index')
            ->with('success', 'Record created successfully.');
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withError('Try again');
        }
    }

    public function edit(Employee $employee)
    {
        $jobCategory = JobCategory::get();
        $country_code = Country::get();
        
        return view('content.employee.edit', compact('employee','jobCategory','country_code'));
    }

    public function update(Request $request)
    {
        $employeeId = $request->route('id');
        $employee = Employee::findOrFail($employeeId);
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'date_of_birth' => 'required',
            'job' => 'required'
            // 'licence' => 'required',
        ]);

        try {
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
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withError('Try again');
        }
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
