<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\DataEntryRepositoryInterface;
use App\Repositories\DataEntryPointRepository;
use App\DataTables\DataEntryPointDataTable;
use App\Models\Employee;
use Illuminate\Support\Str;
use App\Models\Client;
use App\Models\Country;
use App\Models\City;
use App\Models\Provience;
use App\Models\EmployeeDataEntryPoint;
use Illuminate\Support\Facades\Storage;
use File;
use App\Models\JobCategory;

class DataEntryPointController extends Controller
{
    private DataEntryPointRepository $DataEntryPointRepository;

    public function __construct(DataEntryPointRepository $DataEntryPointRepository) 
    {
        $this->DataEntryPointRepository = $DataEntryPointRepository;
    }

    public function index(DataEntryPointDataTable $dataTable)
    {
        $jobCategory = JobCategory::get();
        $client = Client::get();
        return $dataTable->render('content.dataEntry.index',compact('jobCategory','client'));
    }

    public function create(){
        $country = Country::get();
        return view('content.dataEntry.add',compact('country'));
    }

    public function store(Request $request) 
    {
        $request->validate([
            'employee_id' => 'required',
            'sin' => 'required',
            'line_1' => 'required',
            'line_2' => 'required',
            'country' => 'required',
            'provience' => 'required',
            'city_id' => 'required',
            'postal_code' => 'required',
            'transit_number' => 'required',
            'institution_number' => 'required',
            'account_number' => 'required',
            'personal_identification' => 'required',
        ]);
        $filename = '';
        if($request->has('personal_identification')) {
            $uploadedFile = $request->file('personal_identification');
            $filename = uniqid(). '.' .File::extension($uploadedFile->getClientOriginalName());
           
            Storage::disk('local')->putFileAs(
              'public/assets',
              $uploadedFile,
              $filename
            );
        }
        $data['personal_identification_file'] = $filename;
        $request->merge($data);

        $client = $this->DataEntryPointRepository->createDataEntry($request->all());
        if($request->message_token != ''){
            return redirect()->route('confirm_job',$request->message_token);
        }else{
            return redirect()->back()
            ->with('success', 'Record created successfully.');
        }
    }

    public function edit($id)
    {
        $dataEntry = EmployeeDataEntryPoint::where('id',$id)->first();
        $employee =  Employee::where('id',$dataEntry->employee_id)->first();

        $country =  Country::get();
        $provience =  Provience::where('country_id',$dataEntry->country)->get();
        $city =  City::where('provience_id',$dataEntry->provience)->get();
        
        return view('content.dataEntry.edit', compact('employee','country','provience','city','dataEntry'));
    }

    public function update(Request $request)
    {
        $dataId = $request->route('id');
        $dataEntry = EmployeeDataEntryPoint::findOrFail($dataId);
        $request->validate([
            'employee_id' => 'required',
            'sin' => 'required',
            'line_1' => 'required',
            'line_2' => 'required',
            'country' => 'required',
            'provience' => 'required',
            'city_id' => 'required',
            'postal_code' => 'required',
            'transit_number' => 'required',
            'institution_number' => 'required',
            'account_number' => 'required'
        ]);
        $filename = $dataEntry->personal_identification;
        if($request->has('personal_identification')) {
            $uploadedFile = $request->file('personal_identification');
            $filename = uniqid(). '.' .File::extension($uploadedFile->getClientOriginalName());
           
            Storage::disk('local')->putFileAs(
              'public/assets',
              $uploadedFile,
              $filename
            );
        }

        $data['personal_identification_file'] = $filename;
        $request->merge($data);

        $orderDetails = $request->only([
            'employee_id',
            'sin',
            'line_1',
            'line_2',
            'country',
            'provience',
            'city_id',
            'postal_code',
            'transit_number',
            'institution_number',
            'account_number',
            'personal_identification',
            'personal_identification_file'
        ]);

        $this->DataEntryPointRepository->updateDataEntry($dataId,$orderDetails);

        return redirect()->back()
        ->with('success', 'Record created successfully.');
    }

    public function contactCheck(Request $request){
        $employee = Employee::where('contact_number',$request->contact_number)->first();
        $dataEntry = EmployeeDataEntryPoint::where('employee_id',$employee->id)->first();
        if($employee && !$dataEntry){
            $response['success'] = true;
        }else{
            $response['success'] = false;
        }
        return response()->json($response);
    }

    public function destory($id){

        $dataEntry = EmployeeDataEntryPoint::findOrFail($id);
        if(Storage::exists('public/assets/'.$dataEntry->personal_identification)){
            Storage::delete('public/assets/'.$dataEntry->personal_identification);
        }
        $this->DataEntryPointRepository->deleteDataEntry($id);

        return true;
    }
    
}
