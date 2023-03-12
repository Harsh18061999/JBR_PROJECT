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

    public function create($token = null)
    {
        $link = Campaign::first();
        if ($link) {
            $firstDate = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
            $secondDate = Carbon::createFromFormat('Y-m-d', date("Y-m-d", strtotime($link->end_date)));
            if($firstDate->gt($secondDate)){
                return view('content.user.error');
            }else{
                $token_value = VerifyAccount::where('token',$token)->first();
                if($token_value && $token_value->status == 1){
                    $jobCategory = JobCategory::get();
                    return view('content.user.employee.create', compact('jobCategory','token_value'));
                }else{
                    return redirect()->route('sendOtp');
                }
            }
        }else{
            return view('content.user.error');
        }
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|unique:employees,email',
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
            $data['countryCode'] = $request->selected_contry_code;
            $request->merge($data);

            $employees = $this->employeeRepository->createEmployee($request->all());
           
            $first_name = $employees->first_name;
            $last_name = $employees->last_name;

            VerifyAccount::where('contact_number',$request->contact_number)->forceDelete();
            // $message = "👏 Hello $first_name $last_name , \n";
            // $message .= "OTP : $randomNumber";

            // $number = '+' . $employees->countryCode . $employees->contact_number;
            // sendMessage($number, $message);
            return redirect()
                ->route('successVerify')
                ->with('success', 'OTP has been send to your whatsapp no.');
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
            $employee = Employee::where('contact_number', $request->contact_number)
                ->first();
            if ($employee) {
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

    public function sendOtp(Request $request){
        return view('content.user.employee.sendOtp');
    }

    public function sendOtpEmployee(Request $request){
        DB::beginTransaction();
        try {
            $randomNumber = random_int(100000, 999999);
            $token = Str::random(40);
            VerifyAccount::create([
                "contact_number" => $request->contact_number,
                "country_code" => $request->countryCode,
                "token" => $token,
                "otp" => $randomNumber
            ]);
            DB::commit();
            $message = "Thank you for choosing Our Brand. Use the following OTP to complete your procedures. OTP is valid for 5 minutes, \n";
            $message .= "OTP : $randomNumber \n";
            $message .= route('verifyNumber', $token);

            $number = '+' . $request->countryCode . $request->contact_number;
            sendMessage($number, $message);
            return redirect()
            ->route('verifyNumber', $token)
            ->with('success', 'OTP has been send to your whatsapp no.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->withError('Try again');
        }
    }

    public function verifyNumber($token)
    {
        $employee = VerifyAccount::where('token', $token)
            ->first();
        if (!$employee) {
            return redirect()->route('userError');
        }else{
            return view('content.user.employee.verifyAccount', compact('token'));
        }
    }

    public function resendOtp(Request $request)
    {
        try {
            $randomNumber = random_int(100000, 999999);

            $employee = VerifyAccount::where('token', $request->token)
                ->first();

            $employee->update([
                'otp' => $randomNumber,
            ]);

            $message = "Thank you for choosing Our Brand. Use the following OTP to complete your procedures. OTP is valid for 5 minutes, \n";
            $message .= "OTP : $randomNumber";

            $number = '+' . $employee->country_code . $employee->contact_number;
            sendMessage($number, $message);
            $response['success'] = true;
            $response['message'] = 'OTP has been send successfully';
            return $response;
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withError('Try again');
        }
    }

    public function verifyEmployeeOtp(Request $request){
        $response['success'] = false;
        $response['message'] = 'OTP does not match.';
        DB::beginTransaction();
        try {
            $verify_token = VerifyAccount::where('token', $request->token)
                ->where('otp', $request->otp)
                ->first();
            if ($verify_token) {
                $start = new Carbon($verify_token->updated_at);
                $end = Carbon::now();
                if ($start->diff($end)->format('%I') > 5) {
                    $response['success'] = false;
                    $response['message'] = 'OTP Has Been Expired Please Resend OTP.';
                    return $response;
                } else {
                    $response['success'] = true;
                    return $response;
                }
            } else {
                $response['success'] = false;
                $response['message'] = 'OTP does not match.';
                return $response;
            }
        } catch (Exception $e) {
            DB::rollback();
            return $response;
        }
    }
    public function verifyOtp(Request $request)
    {
        DB::beginTransaction();
        try {
            $verify_token = VerifyAccount::where('token', $request->token_value)
                ->where('otp', $request->otp)
                ->first();
            if ($verify_token) {
                $start = new Carbon($verify_token->updated_at);
                $end = Carbon::now();
                if ($start->diff($end)->format('%I') > 5) {
                    return redirect()
                    ->back()
                    ->withError('Try again');
                } else {
                    VerifyAccount::where('token', $request->token_value)->update([
                        "status" => '1'
                    ]);
                    $message = "Your Phone Number Has Been Verified, \n";
                    $message .= route('employee_register', $request->token_value)." use this link to further process.";
        
                    $number = '+' . $request->countryCode . $request->contact_number;
                    sendMessage($number, $message);
                    DB::commit();
                    $link = Campaign::first();
                    return redirect()
                    ->route('employee_register',$request->token_value)
                    ->withSuccess('Phone nuber hass been verify');
                }
            } else {
                return redirect()
                    ->back()
                    ->withError('Try again');
            }
        } catch (Exception $e) {
            DB::rollback();
            return $response;
        }
    }

    public function successVerify()
    {
        return view('content.user.success');
    }

    public function userError()
    {
        return view('content.user.error');
    }
}
