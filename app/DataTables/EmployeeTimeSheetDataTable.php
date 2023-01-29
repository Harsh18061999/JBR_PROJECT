<?php

namespace App\DataTables;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use App\Models\JobConfirmation;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EmployeeTimeSheetDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->rawColumns(['action','job_status','time_sheet_status','job_title','client','supervisor'])
        ->addColumn('employee_name', function($query){
            return isset($query->employee) ? $query->employee->first_name .' '.$query->employee->last_name : '';
        })
        ->addColumn('action', function($query){
            if($query->job_status == 2){
                return "N/A";
            }else{
                return '<div class="d-flex justify-content-center align-items-center"><input type="checkbox" class="job_alert" value="'.$query->id.'" /><i class="mx-2 time_sheet_message text-success font-weight-bold pointer fa-brands fa-lg fa-whatsapp" data-id="'.$query->id.'"></i></div>';
            }
        })
        ->addColumn('job_date', function($query){
            return isset($query->job) ? $query->job->job_date : '';
        })
        ->addColumn('job_title', function($query){
            return isset($query->job) ? $query->job->jobCategory->job_title : '';
        })
        ->addColumn('client', function($query){
            return isset($query->job) ? $query->job->client->client_name : '';
        })
        ->addColumn('supervisor', function($query){
            return isset($query->job) ? $query->job->client->supervisor : '';
        })
        ->addColumn('job_time', function($query){
            return isset($query->job) ? $query->job->start_time : '0:00';
        })
        ->addColumn('job_status', function($query){
            if($query->job_status == 0){
                return '<span class="badge bg-label-primary me-1">Pending</span>';
            }else if($query->job_status == 1){
                return '<span class="badge bg-label-warning me-1">On Going</span>';
            }else if($query->job_status == 2){
                return '<span class="badge bg-label-success me-1">Completed</span>';
            }
        })
        ->addColumn('time_sheet_status', function($query){
            if($query->time_sheet == 0){
                return '<a href="'.route('employee_timesheet.create',$query->id).'"><i class="fa-solid fa-pen-to-square pe-auto" title="Add workig time"></i></a><span class="badge bg-label-primary me-1">Pending</span>';
            }else if($query->time_sheet == 1){
                return '<span class="badge bg-label-success me-1">Completed</span>';
            }
        })
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(JobConfirmation $model,Request $request): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        // dd($this->getColumns());
        return $this->builder()
                    ->setTableId('employee-timesheet-table')
                    ->columns($this->getColumns())
                    ->postAjax([
                        'url' => route('employee_timesheet.index'),
                        'data' => 'function(search) {
                            search._token = "{{ csrf_token() }}";
                            search.employee_name = $("#employee_name").val();
                            search.job_title = $("#job_title").val();
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
                        'processing' => true,
                        'serverSide' => true,
                        'scrollX' => true,
                        'bAutoWidth' => false,
                        'language' => [
                            ],
                        'drawCallback' => "function () {
                          
                            function format(d) {
                                // `d` is the original data object for the row
                                console.log(d)
                                var string = '<table class='+'table table-bordered'+'>'+
                                ' <thead>'+
                                '<tr>'+
                                '<th scope='+'col'+'>'+'#</th>'+
                                '<th scope='+'col'+'>'+'Job Date</th>'+
                                '<th scope='+'col'+'>'+'Start Time</th>'+
                                '<th scope='+'col'+'>'+'Brek Time</th>'+
                                '<th scope='+'col'+'>'+'End Time</th>'+
                                '</tr>'+
                                '</thead>'+'<tbody>';
                                if(d.length > 0){
                                    d.forEach(function(fetch) {  
                                        string += '<tr>';
                                        string += '<td>'+fetch.id+'</td>';
                                        string += '<td>'+fetch.job_date+'</td>';
                                        string += '<td>'+fetch.start_time+'</td>';
                                        string += '<td>'+fetch.break_time+'</td>';
                                        string += '<td>'+fetch.end_time+'</td>';
                                        string += '</tr>';
                                    });  
                                }else{
                                    string += '<tr>';
                                    string += '<td colspan='+5+' class='+'text-center'+'>'+'No result Found'+'</td>';
                                    string += '</tr>';
                                }
                                string += '</tbody>'+'</table>';
                                return (
                                    string
                                );
                            }
                            function getTimesheet(id){
                                var data = '';
                                 $.ajax({
                                    type: 'get',
                                    url: '/get_job_timesheet',
                                    contentType: 'application/json',
                                    dataType: 'json',
                                    async: false,
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                                    },
                                    data:{
                                        id:id
                                    },
                                    success: function(response) {
                                        data = response; 
                                    }
                                });
                                return data;
                            }
                            let table = $('#employee-timesheet-table').DataTable();
                            $('#employee-timesheet-table tbody').on('click', 'td.dt-control', function () {
                                var tr = $(this).closest('tr');
                                var row = table.row(tr);
                         
                                if (row.child.isShown()) {
                                    // This row is already open - close it
                                    row.child.hide();
                                    tr.removeClass('shown');
                                } else {
                                    // Open this row
                                    var data = row.data();
                                    var response = getTimesheet(data.id);
                                    row.child(format(response)).show();
                                    tr.addClass('shown');
                                }
                            });
                        }",
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
           
            Column::make('')
                ->title('')
                ->searchable(false)
                ->orderable(false)
                ->className('dt-control')
                ->defaultContent('')
                ->exportable(false)
                ->printable(false),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)->addClass('text-center'),
            // Column::make('id'),
            Column::make('employee_name') ,
            Column::make('job_title') ,
            Column::make('client') ,
            Column::make('supervisor') ,
            Column::make('job_date') ,
            Column::make('job_time') ,
            Column::make('job_status'),
            Column::make('time_sheet_status'),
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
