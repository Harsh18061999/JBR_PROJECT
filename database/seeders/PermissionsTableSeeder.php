<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 6,
                'name' => 'dashboard',
                'guard_name' => 'web',
                'created_at' => '2023-02-18 23:37:52',
                'updated_at' => '2023-02-18 23:37:52',
                'title' => 'Home Page',
                'description' => 'dashboard',
            ),
            1 => 
            array (
                'id' => 7,
                'name' => 'Campaign.index',
                'guard_name' => 'web',
                'created_at' => '2023-02-18 23:43:48',
                'updated_at' => '2023-02-18 23:43:48',
                'title' => 'Campaign Link',
                'description' => 'index',
            ),
            2 => 
            array (
                'id' => 8,
                'name' => 'Campaign.store',
                'guard_name' => 'web',
                'created_at' => '2023-02-18 23:43:48',
                'updated_at' => '2023-02-18 23:43:48',
                'title' => 'Campaign Link',
                'description' => 'store',
            ),
            3 => 
            array (
                'id' => 9,
                'name' => 'employee.update',
                'guard_name' => 'web',
                'created_at' => '2023-02-18 23:47:23',
                'updated_at' => '2023-02-20 17:40:23',
                'title' => 'Employee',
                'description' => 'update',
            ),
            4 => 
            array (
                'id' => 10,
                'name' => 'employee.destory',
                'guard_name' => 'web',
                'created_at' => '2023-02-18 23:47:51',
                'updated_at' => '2023-02-18 23:47:51',
                'title' => 'Employee',
                'description' => 'delete',
            ),
            5 => 
            array (
                'id' => 11,
                'name' => 'employee.store',
                'guard_name' => 'web',
                'created_at' => '2023-02-18 23:47:51',
                'updated_at' => '2023-02-18 23:47:51',
                'title' => 'Employee',
                'description' => 'Add',
            ),
            6 => 
            array (
                'id' => 12,
                'name' => 'job_category.index',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:02:18',
                'updated_at' => '2023-02-20 17:02:18',
                'title' => 'Job Category',
                'description' => 'Index',
            ),
            7 => 
            array (
                'id' => 13,
                'name' => 'job_category.store',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:02:18',
                'updated_at' => '2023-02-20 17:02:18',
                'title' => 'Job Category',
                'description' => 'store',
            ),
            8 => 
            array (
                'id' => 14,
                'name' => 'job_category.create',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:02:18',
                'updated_at' => '2023-02-20 17:02:18',
                'title' => 'Job Category',
                'description' => 'create',
            ),
            9 => 
            array (
                'id' => 15,
                'name' => 'job_category.update',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:02:18',
                'updated_at' => '2023-02-20 17:02:18',
                'title' => 'Job Category',
                'description' => 'update',
            ),
            10 => 
            array (
                'id' => 16,
                'name' => 'job_category.destroy',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:02:18',
                'updated_at' => '2023-02-20 17:02:18',
                'title' => 'Job Category',
                'description' => 'delete',
            ),
            11 => 
            array (
                'id' => 17,
                'name' => 'job_category.show',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:02:18',
                'updated_at' => '2023-02-20 17:02:18',
                'title' => 'Job Category',
                'description' => 'show',
            ),
            12 => 
            array (
                'id' => 18,
                'name' => 'job_category.edit',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:02:18',
                'updated_at' => '2023-02-20 17:02:18',
                'title' => 'Job Category',
                'description' => 'edit',
            ),
            13 => 
            array (
                'id' => 19,
                'name' => 'client.index',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:05:51',
                'updated_at' => '2023-02-20 17:05:51',
                'title' => 'Client',
                'description' => 'index',
            ),
            14 => 
            array (
                'id' => 20,
                'name' => 'client.store',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:05:51',
                'updated_at' => '2023-02-20 17:05:51',
                'title' => 'Client',
                'description' => 'store',
            ),
            15 => 
            array (
                'id' => 21,
                'name' => 'client.block',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:05:51',
                'updated_at' => '2023-02-20 17:05:51',
                'title' => 'Client',
                'description' => 'block',
            ),
            16 => 
            array (
                'id' => 22,
                'name' => 'client.unblock',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:05:51',
                'updated_at' => '2023-02-20 17:05:51',
                'title' => 'Client',
                'description' => 'unblock',
            ),
            17 => 
            array (
                'id' => 23,
                'name' => 'client.create',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:05:51',
                'updated_at' => '2023-02-20 17:05:51',
                'title' => 'Client',
                'description' => 'create',
            ),
            18 => 
            array (
                'id' => 24,
                'name' => 'client.show',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:05:51',
                'updated_at' => '2023-02-20 17:05:51',
                'title' => 'Client',
                'description' => 'show',
            ),
            19 => 
            array (
                'id' => 25,
                'name' => 'client.update',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:05:51',
                'updated_at' => '2023-02-20 17:05:51',
                'title' => 'Client',
                'description' => 'update',
            ),
            20 => 
            array (
                'id' => 26,
                'name' => 'client.destory',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:05:51',
                'updated_at' => '2023-02-21 17:17:27',
                'title' => 'Client',
                'description' => 'delete',
            ),
            21 => 
            array (
                'id' => 27,
                'name' => 'client.edit',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:05:51',
                'updated_at' => '2023-02-20 17:05:51',
                'title' => 'Client',
                'description' => 'edit',
            ),
            22 => 
            array (
                'id' => 28,
                'name' => 'employee.edit',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:08:16',
                'updated_at' => '2023-02-20 17:08:16',
                'title' => 'Employee',
                'description' => 'edit',
            ),
            23 => 
            array (
                'id' => 29,
                'name' => 'employee.show',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:08:16',
                'updated_at' => '2023-02-20 17:08:16',
                'title' => 'Employee',
                'description' => 'show',
            ),
            24 => 
            array (
                'id' => 30,
                'name' => 'employee.status_update',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:08:16',
                'updated_at' => '2023-02-20 17:08:16',
                'title' => 'Employee',
                'description' => 'status update',
            ),
            25 => 
            array (
                'id' => 31,
                'name' => 'employee.create',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:08:16',
                'updated_at' => '2023-02-20 17:08:16',
                'title' => 'Employee',
                'description' => 'create',
            ),
            26 => 
            array (
                'id' => 32,
                'name' => 'job_request.index',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:10:41',
                'updated_at' => '2023-02-20 17:10:41',
                'title' => 'job_request',
                'description' => 'index',
            ),
            27 => 
            array (
                'id' => 33,
                'name' => 'job_request.store',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:10:41',
                'updated_at' => '2023-02-20 17:10:41',
                'title' => 'job_request',
                'description' => 'store',
            ),
            28 => 
            array (
                'id' => 34,
                'name' => 'job_request.create',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:10:41',
                'updated_at' => '2023-02-20 17:10:41',
                'title' => 'job_request',
                'description' => 'create',
            ),
            29 => 
            array (
                'id' => 35,
                'name' => 'job_request.edit',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:10:41',
                'updated_at' => '2023-02-20 17:10:41',
                'title' => 'job_request',
                'description' => 'edit',
            ),
            30 => 
            array (
                'id' => 36,
                'name' => 'job_request.update',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:10:41',
                'updated_at' => '2023-02-20 17:10:41',
                'title' => 'job_request',
                'description' => 'update',
            ),
            31 => 
            array (
                'id' => 37,
                'name' => 'job_request.destory',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:10:41',
                'updated_at' => '2023-02-20 17:10:41',
                'title' => 'job_request',
                'description' => 'delete',
            ),
            32 => 
            array (
                'id' => 38,
                'name' => 'get_supervisor',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:10:41',
                'updated_at' => '2023-02-20 17:10:41',
                'title' => 'job_request',
                'description' => 'supervisor',
            ),
            33 => 
            array (
                'id' => 39,
                'name' => 'job_request_details',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:13:41',
                'updated_at' => '2023-02-20 17:13:41',
                'title' => 'job_request_details',
                'description' => 'index',
            ),
            34 => 
            array (
                'id' => 40,
                'name' => 'searchResult',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:13:41',
                'updated_at' => '2023-02-20 17:13:41',
                'title' => 'job_request_details',
                'description' => 'job search',
            ),
            35 => 
            array (
                'id' => 41,
                'name' => 'regularDataTable',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:13:41',
                'updated_at' => '2023-02-20 17:13:41',
                'title' => 'job_request_details',
                'description' => 'regularDataTable',
            ),
            36 => 
            array (
                'id' => 42,
                'name' => 'availableDataTable',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:13:41',
                'updated_at' => '2023-02-20 17:13:41',
                'title' => 'job_request_details',
                'description' => 'availableDataTable',
            ),
            37 => 
            array (
                'id' => 43,
                'name' => 'onCallDataTable',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:13:41',
                'updated_at' => '2023-02-20 17:13:41',
                'title' => 'job_request_details',
                'description' => 'onCallDataTable',
            ),
            38 => 
            array (
                'id' => 44,
                'name' => 'onGoingJob',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:13:41',
                'updated_at' => '2023-02-20 17:13:41',
                'title' => 'job_request_details',
                'description' => 'onGoingJob',
            ),
            39 => 
            array (
                'id' => 45,
                'name' => 'sendMessageJob',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:13:41',
                'updated_at' => '2023-02-20 17:13:41',
                'title' => 'job_request_details',
                'description' => 'sendMessageJob',
            ),
            40 => 
            array (
                'id' => 46,
                'name' => 'sendBulkMessageJob',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:13:41',
                'updated_at' => '2023-02-20 17:13:41',
                'title' => 'job_request_details',
                'description' => 'sendBulkMessageJob',
            ),
            41 => 
            array (
                'id' => 47,
                'name' => 'employeeaCount',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:13:41',
                'updated_at' => '2023-02-20 17:13:41',
                'title' => 'job_request_details',
                'description' => 'employeeaCount',
            ),
            42 => 
            array (
                'id' => 48,
                'name' => 'data_entry_point.index',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:14:54',
                'updated_at' => '2023-02-20 17:14:54',
                'title' => 'data_entry_point',
                'description' => 'index',
            ),
            43 => 
            array (
                'id' => 49,
                'name' => 'data_entry_point.store',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:14:54',
                'updated_at' => '2023-02-20 17:14:54',
                'title' => 'data_entry_point',
                'description' => 'store',
            ),
            44 => 
            array (
                'id' => 50,
                'name' => 'data_entry_point.create',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:14:54',
                'updated_at' => '2023-03-03 17:54:36',
                'title' => 'data_entry_point',
                'description' => 'create',
            ),
            45 => 
            array (
                'id' => 51,
                'name' => 'data_entry_point.update',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:14:54',
                'updated_at' => '2023-02-20 17:14:54',
                'title' => 'data_entry_point',
                'description' => 'update',
            ),
            46 => 
            array (
                'id' => 52,
                'name' => 'data_entry_point.destory',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:14:54',
                'updated_at' => '2023-02-20 17:14:54',
                'title' => 'data_entry_point',
                'description' => 'delete',
            ),
            47 => 
            array (
                'id' => 53,
                'name' => 'data_entry_point.show',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:14:54',
                'updated_at' => '2023-02-20 17:14:54',
                'title' => 'data_entry_point',
                'description' => 'show',
            ),
            48 => 
            array (
                'id' => 54,
                'name' => 'weekly_scheduler.index',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:15:34',
                'updated_at' => '2023-02-20 17:15:34',
                'title' => 'weekly_scheduler',
                'description' => 'index',
            ),
            49 => 
            array (
                'id' => 55,
                'name' => 'weekly_scheduler.datatable',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:15:34',
                'updated_at' => '2023-02-20 17:15:34',
                'title' => 'weekly_scheduler',
                'description' => 'datatable',
            ),
            50 => 
            array (
                'id' => 56,
                'name' => 'employee_timesheet.index',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:16:36',
                'updated_at' => '2023-02-20 17:16:36',
                'title' => 'employee_timesheet',
                'description' => 'index',
            ),
            51 => 
            array (
                'id' => 57,
                'name' => 'employee_timesheet.create',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:16:36',
                'updated_at' => '2023-02-20 17:16:36',
                'title' => 'employee_timesheet',
                'description' => 'create',
            ),
            52 => 
            array (
                'id' => 58,
                'name' => 'employee_timesheet.store',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:16:36',
                'updated_at' => '2023-02-20 17:16:36',
                'title' => 'employee_timesheet',
                'description' => 'store',
            ),
            53 => 
            array (
                'id' => 59,
                'name' => 'getTimeSheet',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:16:36',
                'updated_at' => '2023-02-20 17:16:36',
                'title' => 'employee_timesheet',
                'description' => 'getTimeSheet',
            ),
            54 => 
            array (
                'id' => 60,
                'name' => 'timeSheetMessage',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:16:36',
                'updated_at' => '2023-02-20 17:16:36',
                'title' => 'employee_timesheet',
                'description' => 'timeSheetMessage',
            ),
            55 => 
            array (
                'id' => 61,
                'name' => 'user.update',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:18:43',
                'updated_at' => '2023-02-20 17:18:43',
                'title' => 'user',
                'description' => 'update',
            ),
            56 => 
            array (
                'id' => 62,
                'name' => 'user.index',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:18:43',
                'updated_at' => '2023-02-20 17:18:43',
                'title' => 'user',
                'description' => 'index',
            ),
            57 => 
            array (
                'id' => 63,
                'name' => 'user.store',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:18:43',
                'updated_at' => '2023-02-20 17:18:43',
                'title' => 'user',
                'description' => 'store',
            ),
            58 => 
            array (
                'id' => 64,
                'name' => 'user.create',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:18:43',
                'updated_at' => '2023-02-20 17:18:43',
                'title' => 'user',
                'description' => 'create',
            ),
            59 => 
            array (
                'id' => 65,
                'name' => 'user.show',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:18:43',
                'updated_at' => '2023-02-20 17:18:43',
                'title' => 'user',
                'description' => 'show',
            ),
            60 => 
            array (
                'id' => 66,
                'name' => 'user.edit',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:18:43',
                'updated_at' => '2023-02-20 17:18:43',
                'title' => 'user',
                'description' => 'edit',
            ),
            61 => 
            array (
                'id' => 67,
                'name' => 'user.destory',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:18:43',
                'updated_at' => '2023-02-20 17:18:43',
                'title' => 'user',
                'description' => 'delete',
            ),
            62 => 
            array (
                'id' => 68,
                'name' => 'user.status_update',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:18:43',
                'updated_at' => '2023-02-20 17:18:43',
                'title' => 'user',
                'description' => 'status_update',
            ),
            63 => 
            array (
                'id' => 69,
                'name' => 'checkUserNumber',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:18:43',
                'updated_at' => '2023-02-20 17:18:43',
                'title' => 'user',
                'description' => 'checkUserNumber',
            ),
            64 => 
            array (
                'id' => 70,
                'name' => 'roles.index',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:20:31',
                'updated_at' => '2023-02-20 17:20:31',
                'title' => 'roles',
                'description' => 'index',
            ),
            65 => 
            array (
                'id' => 71,
                'name' => 'roles.create',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:20:31',
                'updated_at' => '2023-02-20 17:20:31',
                'title' => 'roles',
                'description' => 'create',
            ),
            66 => 
            array (
                'id' => 72,
                'name' => 'roles.update',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:20:31',
                'updated_at' => '2023-02-21 16:23:08',
                'title' => 'roles',
                'description' => 'update',
            ),
            67 => 
            array (
                'id' => 73,
                'name' => 'roles.show',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:20:31',
                'updated_at' => '2023-02-20 17:20:31',
                'title' => 'roles',
                'description' => 'show',
            ),
            68 => 
            array (
                'id' => 74,
                'name' => 'roles.edit',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:20:31',
                'updated_at' => '2023-02-21 16:21:40',
                'title' => 'roles',
                'description' => 'edit',
            ),
            69 => 
            array (
                'id' => 75,
                'name' => 'roles.store',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:20:31',
                'updated_at' => '2023-02-20 17:20:31',
                'title' => 'roles',
                'description' => 'store',
            ),
            70 => 
            array (
                'id' => 76,
                'name' => 'roles_destroy.destory',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:20:31',
                'updated_at' => '2023-02-20 17:20:31',
                'title' => 'roles',
                'description' => 'delete',
            ),
            71 => 
            array (
                'id' => 77,
                'name' => 'permissions.index',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:21:54',
                'updated_at' => '2023-02-20 17:21:54',
                'title' => 'permissions',
                'description' => 'index',
            ),
            72 => 
            array (
                'id' => 78,
                'name' => 'permissions.store',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:21:54',
                'updated_at' => '2023-02-20 17:21:54',
                'title' => 'permissions',
                'description' => 'store',
            ),
            73 => 
            array (
                'id' => 79,
                'name' => 'permissions.create',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:21:54',
                'updated_at' => '2023-02-20 17:21:54',
                'title' => 'permissions',
                'description' => 'create',
            ),
            74 => 
            array (
                'id' => 80,
                'name' => 'permissions.update',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:21:54',
                'updated_at' => '2023-02-20 17:21:54',
                'title' => 'permissions',
                'description' => 'update',
            ),
            75 => 
            array (
                'id' => 81,
                'name' => 'permissions.destory',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:21:54',
                'updated_at' => '2023-02-20 17:21:54',
                'title' => 'permissions',
                'description' => 'delete',
            ),
            76 => 
            array (
                'id' => 82,
                'name' => 'permissions.show',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:21:54',
                'updated_at' => '2023-02-20 17:21:54',
                'title' => 'permissions',
                'description' => 'show',
            ),
            77 => 
            array (
                'id' => 83,
                'name' => 'permissions.edit',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:21:54',
                'updated_at' => '2023-02-20 17:21:54',
                'title' => 'permissions',
                'description' => 'edit',
            ),
            78 => 
            array (
                'id' => 86,
                'name' => 'employee.index',
                'guard_name' => 'web',
                'created_at' => '2023-02-20 17:40:23',
                'updated_at' => '2023-02-20 17:40:23',
                'title' => 'Employee',
                'description' => 'index',
            ),
        ));
        
        
    }
}