<?php

namespace App\DataTables;

use App\Models\User;
use App\Models\JobRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class WeeklyDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {   
        return (new EloquentDataTable($query))->rawColumns(['action','status'])
            ->addColumn('action', function($query){
                return view('content.user.user.action',compact('query'));
            })->addColumn('status', function($query){
                return view('content.user.user.status',compact('query'));
             })
            ->setRowId('id');
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
        $model = $model->with(['employees','supervisor','jobCategory','jobConfirmation']);
        // ->whereDate('job_date','>=',$week_start)
        // ->whereDate('job_date','<=',$week_end);
        $data = $model->get()->toArray();
        $all_data = array();
        foreach($data as $k => $value){
            dd($value);
            $period = CarbonPeriod::create($job->job_date, $job->end_date);
    
            foreach ($period as $date) {
                // $all_data[$date->format('Y-m-d')] =  ;
            }
        }
        dd($model->get()->toArray());
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
                    ->setTableId('weekly-table')
                    ->columns($this->getColumns())
                    ->postAjax([
                        'url' => route('weekly_scheduler.index'),
                        'data' => 'function(search) {
                            search._token = "{{ csrf_token() }}";
                            search.user_name = $("#user_name").val();
                            search.status = $("#status").val();
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
                        'scrollX' => false,
                        'bAutoWidth' => false,
                        'language' => [
                            ],
                        'initComplete' => "function () {
                            var self = this.api();
                        }",
                        
                    ])
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->responsive(true)->addTableClass('table table-striped table-row-bordered gy-5 gs-7 border');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {   
        return [
            // Column::make('id'),
            Column::make('date') ,
            Column::make('email') ,
            Column::make('status'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Posts_' . date('YmdHis');
    }
}
