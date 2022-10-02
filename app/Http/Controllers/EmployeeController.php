<?php

namespace App\Http\Controllers;

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

    public function index(EmployeeDataTable $dataTable)
    {
        $jobCategory = JobCategory::get();
        return $dataTable->render('content.employee.index',compact('jobCategory'));
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
            'email' => 'required',
            'contact_number' => 'required',
            'date_of_birth' => 'required',
            'job' => 'required'
            // 'licence' => 'required',
        ]);

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
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'contact_number' => 'required',
            'date_of_birth' => 'required',
            'job' => 'required'
            // 'licence' => 'required',
        ]);

        $orderDetails = $request->only([
            'first_name',
            'last_name',
            'email',
            'contact_number',
            'date_of_birth',
            'job'
        ]);

        $this->employeeRepository->updateEmployee($employeeId,$orderDetails);

        return redirect()->route('employee.index')
            ->with('success', 'Employee updated successfully');
    }

    public function destory($id){
        $this->employeeRepository->deleteEmployee($id);

        return true;
    }
}
