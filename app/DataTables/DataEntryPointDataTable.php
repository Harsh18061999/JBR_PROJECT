<?php

namespace App\DataTables;

use App\Models\EmployeeDataEntryPoint;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DataEntryPointDataTable extends DataTable
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
                return view('content.dataEntry.action',compact('query'));
            })
            ->addColumn('employee_id', function($query){
                return strtoupper($query->employee_title->first_name).' '.strtoupper($query->employee_title->last_name);
            })
            ->addColumn('country', function($query){
                return  strtoupper($query->country_title->name);
            })
            ->addColumn('provience', function($query){
                return  strtoupper($query->provience_title->provience_name);
            })
            ->addColumn('city_id', function($query){
                return  strtoupper($query->city_title->city_title);
            })
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(EmployeeDataEntryPoint $model,Request $request): QueryBuilder
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
        $print = [
            [
                'extend'=> 'print',
                'text'=> 'Print',
                'title'=> 'All JobCategory',
                'exportOptions' =>  [
                'columns' => [2,3,4,5,6,7,8,9,10,11,12],
                ],
                'footer'=> true,
                'autoPrint'=> true
            ],
            [
                'extend'=> 'csv',
                'text'=> 'Csv',
                'title'=> 'All JobCategory',
                'exportOptions' =>  [
                'columns' => [2,3,4,5,6,7,8,9,10,11,12],
                ],
                'footer'=> true,
                'autoPrint'=> true
            ],
            [
                'extend'=> 'excel',
                'text'=> 'Excel',
                'title'=> 'All JobCategory',
                'exportOptions' =>  [
                'columns' => [2,3,4,5,6,7,8,9,10,11,12],
                ],
                'customize'=> "function ( doc ) {
                    doc.content[0].alignment = 'center';
                    doc.styles.tableHeader.alignment = 'left';
                  }",
                'footer'=> true,
                'autoPrint'=> true
            ],
            [
                'extend'=> 'pdf',
                'text'=> 'Pdf',
                'title'=> 'All JobCategory',
                'exportOptions' =>  [
                'columns' => [2,3,4,5,6,7,8,9,10,11,12],
                ],
                'footer'=> true,
                'autoPrint'=> true
            ],
            'colvis'
        ];
        return $this->builder()
                    ->setTableId('data-entry-table')
                    ->columns($this->getColumns())
                    ->postAjax([
                        'url' => route('data_entry_point.index'),
                        'data' => 'function(search) {
                            search._token = "{{ csrf_token() }}";
                            search.client_name = $("#client_name").val();
                            search.supervisor = $("#supervisor").val();
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
                        'processing' => true,
                        'serverSide' => true,
                        'scrollX' => true,
                        "scrollY" => false,
                        "scrollCollapse" => true,  
                        "fixedColumns" => true,
                        "fixedColumns" =>  [
                            "left" => 1,
                        ],
                        'bAutoWidth' => false,
                        'language' => [
                            ],
                        'initComplete' => "function () {
                            var self = this.api();
                        }",
                        
                    ])
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
            // Column::make('')
            // ->title('')
            // ->searchable(false)
            // ->orderable(false)
            // ->className('dt-control')
            // ->defaultContent('')
            // ->exportable(false)
            // ->printable(false),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->sortable(false)
                  ->width(60),
            Column::make('employee_id')->title('Employee')->width(200),
            Column::make('sin')->width(200),
            Column::make('line_1')->title('Line1'),
            Column::make('line_2'),
            Column::make('country'),
            Column::make('provience'),
            Column::make('city_id'),
            Column::make('postal_code'),
            Column::make('transit_number'),
            Column::make('institution_number'),
            Column::make('account_number')
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
