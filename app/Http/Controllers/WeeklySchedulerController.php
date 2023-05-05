<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobCategory;
use App\Models\JobRequest;
use App\Models\JobConfirmation;
use App\Models\Employee;
use App\Models\Client;
use App\Models\Country;
use App\Models\Leave;
use App\Models\ReaAllocate;
use App\Models\SendMessage;
use App\Models\Supervisor;
use App\DataTables\WeeklyDataTable;
use Yajra\DataTables\Facades\DataTables;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;
use DB;
class WeeklySchedulerController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $client = Client::get();
        $role = $user->getRoleNames()->toArray();
        $role_name = isset($role[0]) ? $role[0] : '';
        $jobCategory = JobCategory::get();

        $model = new JobRequest();
        $role = auth()
            ->user()
            ->getRoleNames()
            ->toArray();
        $role_name = isset($role[0]) ? $role[0] : '';
        if ($role_name != 'admin') {
        } else {
        }

        $supervisor_id = [];
        $supervisor = [];
        if ($user->hasRole('admin')) {
            if ($request->supervisor && $request->supervisor != '') {
                $model = $model->where('supervisor_id', $request->supervisor);
            } elseif ($request->client_name && $request->client_name != '') {
                $client_id = Supervisor::where('client_id', $request->client_name)
                    ->pluck('id')
                    ->toArray();
                $model = $model->whereIn('supervisor_id', $client_id);
            }
            
        } else {
            if ($request->supervisor && $request->supervisor != '') {
                $model = $model->where('supervisor_id', $request->supervisor);
            } else {
                $supervisor_id = Supervisor::where('client_id', auth()->user()->client_id)
                    ->pluck('id')
                    ->toArray();
                if (!empty($supervisor_id)) {
                    $model = $model->whereIn('supervisor_id', $supervisor_id);
                }
            }
            $supervisor = new Supervisor();
            $supervisor = $supervisor->where('client_id', $user->client->id)->get();
            $supervisor_id = $supervisor->pluck('id')->toArray();
        }

        // if(!empty($supervisor_id)){
        //     $model = $model->query()->whereIn("supervisor_id",$supervisor_id);
        // }
        $model = $model->with(['employees', 'supervisor.client', 'jobCategory', 'jobConfirmation', 'leave', 'reallocate.employee']);

        if ($request->custome_range == 2) {
            $previous_week = strtotime('-1 week +1 day');
            $start_week = strtotime('last sunday midnight', $previous_week);
            $end_week = strtotime('next saturday', $start_week);
            $week_start = date('Y-m-d', $start_week);
            $week_end = date('Y-m-d', $end_week);
        } elseif ($request->custome_range == 3) {
            $week_start = $request->job_date;
            $week_end = $request->end_date;
        } else {
            $day = date('w');
            $week_start = date('Y-m-d-', strtotime('-' . $day . ' days'));
            $week_end = date('Y-m-d', strtotime('+' . (6 - $day) . ' days'));
        }
        $model = $model->whereDate('job_date', '>=', $week_start)->whereDate('job_date', '<=', $week_end);
        $data = $model->get()->toArray();
        $all_data = [];
        foreach ($data as $k => $value) {
            $client_name = $value['supervisor']['client']['client_name'];
            $supervisour = $value['supervisor']['supervisor'];
            $period = CarbonPeriod::create($value['job_date'], $value['end_date']);

            foreach ($period as $date) {
                $employee = collect($value['employees']);
                if (!empty($value['leave'])) {
                    $leave = collect($value['leave']);
                    $newemployee = collect($value['reallocate']);
                    $leaveRequest = $leave->where('leave_date', $date->format('Y-m-d'))->first();
                    if ($leaveRequest) {
                        $key = $employee->search(function ($item) use ($leaveRequest) {
                            return $item['id'] == $leaveRequest['employee_id'];
                        });
                        $employee->pull($key);
                        $newEmployee = $newemployee
                            ->where('employee_id', $leaveRequest['user_id'])
                            ->where('re_allocate_date', $date->format('Y-m-d'))
                            ->first();
                        // dd($newEmployee['employee']);
                        if (!empty($newEmployee['employee'])) {
                            $employee->push($newEmployee['employee']);
                        }
                    }
                }
                $all_data[$date->format('Y-m-d')][] = [
                    'id' => $value['id'],
                    'client_name' => $client_name,
                    'supervisour' => $supervisour,
                    'employee' => $employee,
                ];
            }
        }
        $search = [
            'custome_range' => $request->custome_range ? $request->custome_range : 1,
            'job_date' => $request->job_date,
            'end_date' => $request->end_date,
            'supervisor' => $request->supervisor,
            'client_name' => $request->client_name,
        ];
        return view('content.weeklyScheduler.index', compact('supervisor', 'client', 'role_name', 'jobCategory', 'all_data', 'search'));
    }

    public function reallocateJob(Request $request)
    {
        // dd($request->all());
        $job = JobRequest::where('id', $request->job_id)->first();
        $jobList = JobRequest::whereDate('job_date', '<=', $request->date)
            ->whereDate('end_date', '>=', $request->date)
            ->pluck('id')
            ->toArray();

        $notavailable = JobConfirmation::whereIn('job_id', $jobList)
            ->pluck('employee_id')
            ->toArray();
        $notavailableEmployee = ReaAllocate::whereDate('re_allocate_date', '<=', $request->date)
            ->whereDate('re_allocate_date', '>=', $request->date)
            ->pluck('employee_id')
            ->toArray();

        $available = Employee::whereNotIn('id', array_merge($notavailable, $notavailableEmployee))->get();
        $response['success'] = $available->count() > 0 ? true : false;
        $response['employee'] = $available;
        $response['job_id'] = $request->job_id;
        $response['job_date'] = $request->date;
        $response['employee_id'] = $request->employee_id;
        return $response;
    }

    public function leave_request(Request $request)
    {
        ReaAllocate::where('employee_id', $request->re_allocate_employee_id)
            ->where('job_id', $request->job_id)
            ->where('re_allocate_date', $request->reallocate_date)
            ->delete();
        Leave::create([
            'job_id' => $request->job_id,
            'employee_id' => $request->re_allocate_employee_id,
            'leave_date' => $request->reallocate_date,
            'user_id' => $request->employee_available,
        ]);
        $employee = Employee::where('id', $request->employee_available)->first();

        $job = JobRequest::where('id', $request->job_id)->first();
        $data['success'] = false;
        $data['message'] = 'something went wrong';
        DB::beginTransaction();
        try {
            if ($job) {
                $message = SendMessage::where('employee_id', $request->re_allocate_employee_id)
                    ->where('job_request_id', $job->id)
                    ->whereDate('job_date', $job->reallocate_date)
                    ->first();
                if ($message) {
                    $data['success'] = true;
                    $data['message'] = 'Message All Redy Been Send.';
                } else {
                    $message_status = SendMessage::create([
                        'confirmation_id' => Str::random(30),
                        'employee_id' => $employee->id,
                        'job_request_id' => $job->id,
                        'job_date' => $request->reallocate_date,
                        'is_reallocate' => '1',
                    ]);
                    $message_data = SendMessage::with('employee')
                        ->where('id', $message_status->id)
                        ->first()
                        ->toArray();

                    $first_name = $message_data['employee']['first_name'];
                    $last_name = $message_data['employee']['last_name'];

                    $message = "Hello $first_name $last_name , \n";
                    $message .= "Here's an interesting job that we think might be relevant for you. \n";
                    $message .= "Please confirm your job below given link. \n";
                    $message .= route('confirm_job', $message_data['confirmation_id']);

                    $country = Country::where('id', $message_data['employee']['countryCode'])->first();
                    $number = '+' . $country->country_code . $message_data['employee']['contact_number'];

                    $send_message = sendMessage('+919737918132', $message);
                    if ($send_message) {
                        SendMessage::where('id', $message_data['id'])->update([
                            'message_status' => '1',
                        ]);
                        $data['success'] = true;
                        $data['message'] = 'Message Has Been Sent successfully.';
                    } else {
                        SendMessage::where('id', $message_data['id'])->update([
                            'message_status' => '2',
                        ]);
                        $data['success'] = false;
                        $data['message'] = 'Somthing Went To Wrong.';
                    }
                }
            }
            DB::commit();
            return redirect()
                ->back()
                ->with('success', 'Job assign successfully.');
        } catch (Exception $e) {
            // drakify('error');
            DB::rollback();
            return redirect()
                ->back()
                ->withError('Try again');
        }
    }
}
