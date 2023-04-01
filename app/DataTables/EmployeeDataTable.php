<?php

namespace App\DataTables;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EmployeeDataTable extends DataTable
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
                return view('content.employee.action',compact('query'));
            })->addColumn('job', function($query){
               return $query->jobCategory->job_title;
            })->addColumn('status', function($query){
                return view('content.employee.status',compact('query'));
             })
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Employee $model,Request $request): QueryBuilder
    {
        // dd($request->all());
        if($request->employee_name && $request->employee_name != ''){
            $model = $model->where('id',$request->employee_name);
        }

        if($request->job_title && $request->job_title != ''){
            $model = $model->where('job',$request->job_title);
        }
        
        if($request->status){
            $model = $model->where('status',(string)($request->status));
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
        $print = [
            [
                'extend'=> 'print',
                'text'=> 'Print',
                'title'=> 'All JobCategory',
                'exportOptions' =>  [
                'columns' => [1,2,3,4,5,6],
                ],
                'footer'=> true,
                'autoPrint'=> true
            ],
            [
                'extend'=> 'csv',
                'text'=> 'Csv',
                'title'=> 'All JobCategory',
                'exportOptions' =>  [
                'columns' => [1,2,3,4,5,6],
                ],
                'footer'=> true,
                'autoPrint'=> true
            ],
            [
                'extend'=> 'excel',
                'text'=> 'Excel',
                'title'=> 'All JobCategory',
                'exportOptions' =>  [
                'columns' => [1,2,3,4,5,6],
                ],
                'footer'=> true,
                'autoPrint'=> true
            ],
            [
                'extend'=> 'pdf',
                'text'=> 'Pdf',
                'title'=> 'All JobCategory',
                'exportOptions' =>  [
                'columns' => [1,2,3,4,5,6],
                ],
                'customize'=> "function ( doc ) {
                    doc.content[0].alignment = 'center';
                    doc.styles.tableHeader.alignment = 'left';
                  }",
                'footer'=> true,
                'autoPrint'=> true
            ],
            'colvis'
        ];
        return $this->builder()
                    ->setTableId('employee-table')
                    ->columns($this->getColumns())
                    ->postAjax([
                        'url' => route('employee.index'),
                        'data' => 'function(search) {
                            search._token = "{{ csrf_token() }}";
                            search.employee_name = $("#employee_name").val();
                            search.job_title = $("#job_title").val();
                            search.status = $("#status").val();
                        }'
                    ])
                    ->parameters([
                        'stateSave' => true,//true,
                        'bScrollInfinite' => true,
                        'responsive' => false,
                        'lengthMenu' => [10, 15, 30, 50, 100],
                        'dom'          => 'Bfrtip',
                        'buttons'      => [ $print],
                        'processing' => false,
                        'serverSide' => true,
                        'scrollX' => false,
                        'bAutoWidth' => false,
                        'scrollX' => true,
                        "scrollY" => false,
                        "scrollCollapse" => true,
                        "fixedColumns" => true,
                        "fixedColumns" =>  [
                            "left" => 1,
                        ],
                        'language' => [
                            ],
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
        return [
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)->addClass('text-center'),
            // Column::make('id'),
            Column::make('first_name') ,
            Column::make('last_name') ,
            Column::make('contact_number') ,
            Column::make('email') ,
            Column::make('date_of_birth') ,
            Column::make('job'),
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
