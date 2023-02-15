<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\EmployeeRepositoryInterface;
use App\DataTables\EmployeeDataTable;
use App\Models\Employee;
use App\Models\EmployeeDataEntryPoint;
use App\Models\Country;
use App\Models\JobCategory;
use App\Models\VerifyAccount;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;
use File;
use Illuminate\Support\Facades\Storage;
use App\Models\Campaign;

class EmployeeController extends Controller
{
    private EmployeeRepositoryInterface $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function create()
    {
        $link = Campaign::first();
        if ($link) {
            $firstDate = Carbon::now();
            $secondDate = Carbon::parse($link->end_date);
            if ($firstDate->greaterThan($secondDate)) {
                return view('content.user.error');
            } else {
                $jobCategory = JobCategory::get();
                return view('content.user.employee.create', compact('jobCategory'));
            }
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|unique:employees,email',
                'countryCode' => 'required',
                'contact_number' => 'required|unique:employees,contact_number',
                'date_of_birth' => 'required',
                'job' => 'required',
                // 'licence' => 'required',
            ]);

            $filename = '';
            if ($request->has('lincense')) {
                $uploadedFile = $request->file('lincense');
                $filename = uniqid() . '.' . File::extension($uploadedFile->getClientOriginalName());
                Storage::disk('local')->putFileAs('public/assets', $uploadedFile, $filename);
            }

            $data['filename'] = $filename;
            $request->merge($data);

            $employees = $this->employeeRepository->createEmployee($request->all());
            $token = Str::random(40);
            $randomNumber = random_int(100000, 999999);
            VerifyAccount::create([
                'token' => $token,
                'employee_id' => $employees->id,
                'otp' => $randomNumber,
            ]);

            $first_name = $employees->first_name;
            $last_name = $employees->last_name;

            $message = "👏 Hello $first_name $last_name , \n";
            $message .= "Thank you for choosing Our Brand. Use the following OTP to complete your procedures. OTP is valid for 5 minutes, \n";
            $message .= "OTP : $randomNumber";

            $number = '+' . $employees->countryCode . $employees->contact_number;
            sendMessage($number, $message);
            return redirect()
                ->route('verifyNumber', $token)
                ->with('success', 'Otp has been send to your whatsapp no.');
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withError('Try again');
        }
    }

    public function success()
    {
        return view('content.user.employee.success');
    }

    public function mailCheck(Request $request)
    {
        $employee = Employee::where('email', $request->email)->first();
        if ($employee) {
            $response['success'] = true;
        } else {
            $response['success'] = false;
        }
        return response()->json($response);
    }

    public function contactCheck(Request $request)
    {
        try {
            $whatsappNumber = json_decode(checkNumber($request->countryCode . $request->contact_number));
            $response['numberCheck'] = $whatsappNumber->status == 'invalid' ? false : true;
            $employee = Employee::withTrashed()->where('contact_number', $request->contact_number)->first();
            if ($employee && $employee->active_status == 1) {
                $response['success'] = true;
            } else {
                $response['success'] = false;
            }
            return response()->json($response);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withError('Try again');
        }
    }

    public function dataEntry($token = '')
    {
        $country = Country::get();
        return view('content.user.employee.data_entry_point', compact('country', 'token'));
    }

    public function getEmployee(Request $request)
    {
        $employee = Employee::where('contact_number', $request->contact_number)->first();
        if ($employee) {
            $dataEntry = EmployeeDataEntryPoint::where('employee_id', $employee->id)->first();
            if ($employee && !$dataEntry) {
                $response['success'] = true;
                $response['employee'] = $employee;
            } else {
                $response['success'] = false;
            }
        } else {
            $response['success'] = false;
        }
        return response()->json($response);
    }

    public function verifyNumber($token)
    {
        $employee = VerifyAccount::with('employee')->where('token', $token)->first();
        if(!$employee){
            return redirect()->route('userError');
        }
        if($employee->employee->active_status == 1){
            return redirect()->route('successVerify');
        }else{
            return view('content.user.employee.verifyAccount',compact('token'));
        }
    }

    public function resendOtp(Request $request)
    {
        try {
            $randomNumber = random_int(100000, 999999);

            $employee = VerifyAccount::with('employee')->where('token',$request->token)->first();
            $first_name = $employee->employee->first_name;
            $last_name = $employee->employee->last_name;

            $employee->update([
                "otp" => $randomNumber
            ]);

            $message = "👏 Hello $first_name $last_name , \n";
            $message .= "Thank you for choosing Our Brand. Use the following OTP to complete your procedures. OTP is valid for 5 minutes, \n";
            $message .= "OTP : $randomNumber";

            $number = '+' . $employee->employee->countryCode . $employee->employee->contact_number;
            sendMessage($number, $message);
            $response['success'] = true;
            $response['message'] = "Otp has been send successfully";
            return $response;
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withError('Try again');
        }
    }

    public function verifyOtp(Request $request){
        $response['success'] = false;
        $response['message'] = "OTP does not match.";
        DB::beginTransaction();
        try {
            $verify_token = VerifyAccount::where('token',$request->token_value)
                ->where('otp',$request->otp)->first();
            if($verify_token){
                $start  = new Carbon($verify_token->updated_at);
                $end = Carbon::now();
                if($start->diff($end)->format('%I') > 5){
                    $response['success'] = false;
                    $response['message'] = "OTP Has Been Expired Please Resend OTP.";
                    return $response;
                }else{
                    Employee::where('id',$verify_token->employee_id)
                        ->update([
                            'active_status' => '1'
                        ]);
                    VerifyAccount::where('token',$request->token_value)->delete();
                    DB::commit();
                    $response['success'] = true;
                    return $response;
                }
            }else{
                $response['success'] = false;
                $response['message'] = "OTP does not match.";
                return $response;
            }
           
        } catch (Exception $e) {
            DB::rollback();
            return $response;
        }
    }

    public function successVerify(){
        return view('content.user.success');
    }

    public function userError(){
        return view('content.user.error');
    }
}
