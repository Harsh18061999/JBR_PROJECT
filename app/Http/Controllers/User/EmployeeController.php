<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\EmployeeRepositoryInterface;
use App\DataTables\EmployeeDataTable;
use App\Models\Employee;
use App\Models\JobCategory;

class EmployeeController extends Controller
{
    private EmployeeRepositoryInterface $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository) 
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function create()
    {
        $jobCategory = JobCategory::get();
        return view('content.user.employee.create',compact('jobCategory'));
    }


    public function store(Request $request) 
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:employees,email',
            'contact_number' => 'required|unique:employees,contact_number',
            'date_of_birth' => 'required',
            'job' => 'required'
            // 'licence' => 'required',
        ]);

        $employees = $this->employeeRepository->createEmployee($request->all());

        return redirect()->back()->with('success', 'Thank you for your application. We will get back to you soon.');

    }

    public function success(){
        return view('content.user.employee.success');
    }
}
