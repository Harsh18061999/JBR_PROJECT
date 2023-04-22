<?php

namespace App\DataTables\Client;

use App\Models\JobRequest;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;   
use Yajra\DataTables\Services\DataTable;

class CurrentJobRequest extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {   
        return (new EloquentDataTable($query))->rawColumns(['action','employee_list','status'])
            ->addColumn('client', function($query){
                return isset($query->supervisor->client) ? $query->supervisor->client->client_name : null;
            })
            ->addColumn('supervisour', function($query){
                return isset($query->supervisor) ? $query->supervisor->supervisor : null;
            })
            ->addColumn('job_category', function($query){
                return $query->jobCategory->job_title;
            })
            ->addColumn('no_of_employee',function($query){
                return $query->jobConfirmation->count().'/'.$query->no_of_employee;
            })
            ->addColumn('status',function($query){
                if($query->status == 0){
                    return '<span class="badge bg-label-primary me-1">Pending</span>';
                }else if($query->status == 1){
                    return '<span class="badge bg-label-warning me-1">On Going</span>';
                }else if($query->status == 2){
                    return '<span class="badge bg-label-success me-1">Completed</span>';
                }
            })
            ->addColumn('employee_list',function($query){
                return  "<div class='text-center'><a href=".route('employee_timesheet.status',$query->id)."><span class='badge bg-label-primary me-1'>
                <div class='d-flex align-items-center'> 
                    <i class='fa-solid fa-eye mx-2'></i>
                </div>
            </span></a></div>";
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(JobRequest $model,Request $request): QueryBuilder
    {
        if($request->custome_range ==2){
            $previous_week = strtotime("-1 week +1 day");
            $start_week = strtotime("last sunday midnight",$previous_week);
            $end_week = strtotime("next saturday",$start_week);
            $week_start = date("Y-m-d",$start_week);
            $week_end = date("Y-m-d",$end_week);
        }else if($request->custome_range == 3){
            $week_start = $request->job_date;
            $week_end = $request->end_date; 
        }else{
            $day = date('w');
            $week_start = date('Y-m-d-', strtotime('-'.$day.' days'));
            $week_end = date('Y-m-d', strtotime('+'.(6-$day).' days'));
        }

        
        $model = $model->with(['employees','supervisor','jobCategory','jobConfirmation'])
        ->whereDate('job_date','>=',$week_start)
        ->whereDate('job_date','<=',$week_end);

        $role = auth()->user()->getRoleNames()->toArray();
        $role_name = isset($role[0]) ? $role[0] : '';
        if($role_name != "admin"){
            if($request->supervisor && $request->supervisor != ''){
                $model = $model->where('supervisor_id',$request->supervisor);
            }else{
                $supervisor_id = Supervisor::where('client_id',auth()->user()->client_id)->pluck('id')->toArray();
                $model = $model->whereIn('supervisor_id',$supervisor_id);
            }
        }else{
            if($request->supervisor && $request->supervisor != ''){
                $model = $model->where('supervisor_id',$request->supervisor);
            }else if($request->client_name && $request->client_name != ''){
                $client_id = Supervisor::where('client_id',$request->client_name)->pluck('id')->toArray();
                $model = $model->whereIn('supervisor_id',$client_id);
            }
        }

        if($request->job_id && $request->job_id != ''){
            $model = $model->where('job_id',$request->job_id);
        }

        if($request->status > -1){
            $model = $model->where('status',$request->status);
        }

        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('client-job-request-table')
                    ->columns($this->getColumns())
                    ->postAjax([
                        'url' => route('client_job_request.index'),
                        'data' => 'function(search) {
                            search._token = "{{ csrf_token() }}";
                            search.job_date = $("#job_date").val();
                            search.end_date = $("#end_date").val();
                            search.client_name = $("#client_name").val();
                            search.supervisor = $("#supervisor").val();
                            search.job_id = $("#job_title").val();
                            search.status = $("#status").val();
                            search.custome_range=$("#custome_range").val();
                        }'
                    ])
                    ->parameters([
                        'dom' => 'Bfrtilp',
                        'stateSave' => true,//true,
                        'bScrollInfinite' => true,
                        'responsive' => true,
                        'lengthMenu' => [10, 15, 30, 50, 100],
                        'buttons' => ['colvis'],
                        'processing' => false,
                        'serverSide' => true,
                        "searching"=> false,
                        'scrollX' => true,
                        'bAutoWidth' => false,
                        'language' => [
                            ],
                            'customize'=> "function ( doc ) {
                                doc.content[0].alignment = 'center';
                                doc.styles.tableHeader.alignment = 'left';
                              }",
                        'initComplete' => "function () {
                            var self = this.api();
                        }",
                        
                    ])
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->responsive(false)->addTableClass('table table-striped table-row-bordered gy-5 gs-7 border');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {  
        if(auth()->user()->hasRole('admin')){
            return [
                Column::make('client')->sortable(false) ,
                Column::make('supervisour')->sortable(false) ,
                Column::make('job_date')->title('Start Date')->sortable(false) ,
                Column::make('end_date')->sortable(false) ,
                Column::make('job_category')->sortable(false) ,
                Column::make('no_of_employee')->sortable(false)->addClass('text-center')   ,
                Column::make('status')->sortable(false)->addClass('text-center')   ,
                Column::make('employee_list')->sortable(false)->addClass('text-center') ,
            ];
        } else{
            return [
                Column::make('supervisour') ,
                Column::make('job_date')->title('Start Date') ,
                Column::make('end_date') ,
                Column::make('job_category') ,
                Column::make('no_of_employee') ,
                Column::make('status') ,
                Column::make('employee_list') ,
            ];
        }
        
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Country_' . date('YmdHis');
    }
}
