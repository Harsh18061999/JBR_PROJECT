<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\User\EmployeeController as UserEmployeeController;
use App\Http\Controllers\User\ClientController as UserClientController;
use App\Http\Controllers\User\JobRequestController as UserJobRequestController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\JobRequestController;
use App\Http\Controllers\ProvienceController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\JobRequestDetailController;
use App\Http\Controllers\DataEntryPointController;
use App\Http\Controllers\JobConfirmationController;
use App\Http\Controllers\WeeklySchedulerController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$controller_path = 'App\Http\Controllers';

// Main Page Route
Route::get('/',function(){
    return redirect(route('login'));
});
// Route::get('/', $controller_path . '\dashboard\Analytics@index')->name('dashboard-analytics');

// layout
Route::get('/layouts/without-menu', $controller_path . '\layouts\WithoutMenu@index')->name('layouts-without-menu');
Route::get('/layouts/without-navbar', $controller_path . '\layouts\WithoutNavbar@index')->name('layouts-without-navbar');
Route::get('/layouts/fluid', $controller_path . '\layouts\Fluid@index')->name('layouts-fluid');
Route::get('/layouts/container', $controller_path . '\layouts\Container@index')->name('layouts-container');
Route::get('/layouts/blank', $controller_path . '\layouts\Blank@index')->name('layouts-blank');

// pages
Route::get('/pages/account-settings-account', $controller_path . '\pages\AccountSettingsAccount@index')->name('pages-account-settings-account');
Route::get('/pages/account-settings-notifications', $controller_path . '\pages\AccountSettingsNotifications@index')->name('pages-account-settings-notifications');
Route::get('/pages/account-settings-connections', $controller_path . '\pages\AccountSettingsConnections@index')->name('pages-account-settings-connections');
Route::get('/pages/misc-error', $controller_path . '\pages\MiscError@index')->name('pages-misc-error');
Route::get('/pages/misc-under-maintenance', $controller_path . '\pages\MiscUnderMaintenance@index')->name('pages-misc-under-maintenance');

// authentication
Route::get('/auth/login-basic', $controller_path . '\authentications\LoginBasic@index')->name('auth-login-basic');
Route::get('/auth/register-basic', $controller_path . '\authentications\RegisterBasic@index')->name('auth-register-basic');
Route::get('/auth/forgot-password-basic', $controller_path . '\authentications\ForgotPasswordBasic@index')->name('auth-reset-password-basic');

// cards
Route::get('/cards/basic', $controller_path . '\cards\CardBasic@index')->name('cards-basic');

// User Interface
Route::get('/ui/accordion', $controller_path . '\user_interface\Accordion@index')->name('ui-accordion');
Route::get('/ui/alerts', $controller_path . '\user_interface\Alerts@index')->name('ui-alerts');
Route::get('/ui/badges', $controller_path . '\user_interface\Badges@index')->name('ui-badges');
Route::get('/ui/buttons', $controller_path . '\user_interface\Buttons@index')->name('ui-buttons');
Route::get('/ui/carousel', $controller_path . '\user_interface\Carousel@index')->name('ui-carousel');
Route::get('/ui/collapse', $controller_path . '\user_interface\Collapse@index')->name('ui-collapse');
Route::get('/ui/dropdowns', $controller_path . '\user_interface\Dropdowns@index')->name('ui-dropdowns');
Route::get('/ui/footer', $controller_path . '\user_interface\Footer@index')->name('ui-footer');
Route::get('/ui/list-groups', $controller_path . '\user_interface\ListGroups@index')->name('ui-list-groups');
Route::get('/ui/modals', $controller_path . '\user_interface\Modals@index')->name('ui-modals');
Route::get('/ui/navbar', $controller_path . '\user_interface\Navbar@index')->name('ui-navbar');
Route::get('/ui/offcanvas', $controller_path . '\user_interface\Offcanvas@index')->name('ui-offcanvas');
Route::get('/ui/pagination-breadcrumbs', $controller_path . '\user_interface\PaginationBreadcrumbs@index')->name('ui-pagination-breadcrumbs');
Route::get('/ui/progress', $controller_path . '\user_interface\Progress@index')->name('ui-progress');
Route::get('/ui/spinners', $controller_path . '\user_interface\Spinners@index')->name('ui-spinners');
Route::get('/ui/tabs-pills', $controller_path . '\user_interface\TabsPills@index')->name('ui-tabs-pills');
Route::get('/ui/toasts', $controller_path . '\user_interface\Toasts@index')->name('ui-toasts');
Route::get('/ui/tooltips-popovers', $controller_path . '\user_interface\TooltipsPopovers@index')->name('ui-tooltips-popovers');
Route::get('/ui/typography', $controller_path . '\user_interface\Typography@index')->name('ui-typography');

// extended ui
Route::get('/extended/ui-perfect-scrollbar', $controller_path . '\extended_ui\PerfectScrollbar@index')->name('extended-ui-perfect-scrollbar');
Route::get('/extended/ui-text-divider', $controller_path . '\extended_ui\TextDivider@index')->name('extended-ui-text-divider');

// icons
Route::get('/icons/boxicons', $controller_path . '\icons\Boxicons@index')->name('icons-boxicons');

// form elements
Route::get('/forms/basic-inputs', $controller_path . '\form_elements\BasicInput@index')->name('forms-basic-inputs');
Route::get('/forms/input-groups', $controller_path . '\form_elements\InputGroups@index')->name('forms-input-groups');

// form layouts
Route::get('/form/layouts-vertical', $controller_path . '\form_layouts\VerticalForm@index')->name('form-layouts-vertical');
Route::get('/form/layouts-horizontal', $controller_path . '\form_layouts\HorizontalForm@index')->name('form-layouts-horizontal');

// tables
Route::get('/tables/basic', $controller_path . '\tables\Basic@index')->name('tables-basic');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('content.dashboard.dashboards-analytics');
    })->name('dashboard');

    //employee
    Route::post('/employee/{id}',[EmployeeController::class,'update'])->name('employee.update');
    Route::delete('/employee/{id}',[EmployeeController::class,'destory'])->name('employee.destory');
    Route::resource('employee', EmployeeController::class);
    Route::get('/employee-status_update/{id}',[EmployeeController::class,'statusUpdate'])->name('employee.status_update');
    // Route::get('/employee-unblock/{id}',[EmployeeController::class,'unBlock'])->name('employee.unblock');

    //Job Category
    Route::prefix('auth')->group(function () {
        Route::resource('job_category', JobCategoryController::class);
        Route::post('/job_category/{id}',[JobCategoryController::class,'update'])->name('job_category.update');
        Route::delete('/job_category/{id}',[JobCategoryController::class,'destroy'])->name('job_category.destroy');
    });

    //Client
    Route::delete('/client/{id}',[ClientController::class,'destory'])->name('client.destory');
    Route::get('/client-block/{id}',[ClientController::class,'block'])->name('client.block');
    Route::get('/client-unblock/{id}',[ClientController::class,'unBlock'])->name('client.unblock');
    Route::post('/client/{id}',[ClientController::class,'update'])->name('client.update');
    Route::resource('client', ClientController::class);

    //JobRequest
    Route::delete('/job_request/{id}',[JobRequestController::class,'destory'])->name('job_request.destory');
    Route::post('/job_request/{id}',[JobRequestController::class,'update'])->name('job_request.update');
    Route::resource('job_request', JobRequestController::class);
    Route::get('/get_supervisor',[JobRequestController::class,'get_supervisor']);

    //Job Request Details
    Route::get('/job_request_details',[JobRequestDetailController::class,'index']);
    Route::get('/job_search_result',[JobRequestDetailController::class,'searchResult']);
    Route::POST('/regularDataTable',[JobRequestDetailController::class,'regularDataTable']);
    Route::POST('/availableDataTable',[JobRequestDetailController::class,'availableDataTable']);
    Route::POST('/onCallDataTable',[JobRequestDetailController::class,'onCallDataTable']);
    Route::POST('/onGoingDataTable',[JobRequestDetailController::class,'onGoingJob']);
    Route::POST('/send_message_job',[JobRequestDetailController::class,'sendMessageJob']);
    Route::POST('/send_bulk_message_job',[JobRequestDetailController::class,'sendBulkMessageJob']);
    Route::GET('/total_employee_count',[JobRequestDetailController::class,'employeeaCount']);

    //Data Entry Point
    Route::delete('/data_entry_point/{id}',[DataEntryPointController::class,'destory'])->name('data_entry_point.destory');
    Route::post('/data_entry_point/{id}',[DataEntryPointController::class,'update'])->name('data_entry_point.update');
    Route::resource('/data_entry_point',DataEntryPointController::class);

    //Weekly Scheduler
    Route::get('/weekly_scheduler',[WeeklySchedulerController::class,'index'])->name('weekly_scheduler.index');
    Route::POST('/weekly_datatable',[WeeklySchedulerController::class,'weeklyJobDataTable'])->name('weekly_scheduler.datatable');
});
Route::get('/employee_mail_check',[UserEmployeeController::class,'mailCheck']);
Route::get('/get_employee',[UserEmployeeController::class,'getEmployee']);
Route::get('/employee_contact_check',[UserEmployeeController::class,'contactCheck']);
Route::get('/employee_contact_check_data',[DataEntryPointController::class,'contactCheck']);
Route::get('/employee_register',[UserEmployeeController::class,'create']);
Route::post('/employee_store',[UserEmployeeController::class,'store'])->name('employee_store');
Route::get('/client_register',[UserClientController::class,'create']);
Route::post('/client_store',[UserClientController::class,'store'])->name('client_store');
Route::get('/employee_store_success',[UserEmployeeController::class,'success'])->name('employee_store_success');

Route::get('/data_entry_point_pay/{token?}',[UserEmployeeController::class,'dataEntry'])->name('front.job_request');

Route::get('/get_provience',[ProvienceController::class,'getProvience']);
Route::get('/get_city',[CityController::class,'getCity']);

Route::get('/confirm_job/{token}',[JobConfirmationController::class,'confirmJob'])->name('confirm_job');
Route::POST('/accept_job',[JobConfirmationController::class,'acceptJob'])->name('acceptJob');
Route::view(uri:'/congratulations',view:'content.user.congratulations');
Route::view(uri:'/cancell',view:'content.user.cancell');
Route::POST('/cancell_job',[JobConfirmationController::class,'cancellJob'])->name('cancellJob');


