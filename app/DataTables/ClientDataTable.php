<?php

namespace App\DataTables;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;

class ClientDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))->rawColumns(['action','status','supervisor'])
            ->addColumn('action', function($query){
                return view('content.client.action',compact('query'));
            })
            ->addColumn('supervisor', function($query){
                return implode(" , ",$query->supervisour->map(function ($lines) {
                    $lines->supervisor = Str::upper($lines->supervisor);
                    return $lines;
                })->pluck('supervisor')->toArray());
            })
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Client $model,Request $request): QueryBuilder
    {
        if($request->client_name && $request->client_name != ''){
            $model = $model->where('id',$request->client_name);
        }

        if($request->supervisor && $request->supervisor != ''){
            $model = $model->where('id',$request->supervisor);
        }

        if($request->job_title && $request->job_title != ''){
            $model = $model->where('job',$request->job_title);
        }
        
        if($request->status){
            $model = $model->where('status',(string)($request->status - 1));
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
                'columns' => [1,2,3],
                ],
                'footer'=> true,
                'autoPrint'=> true
            ],
            [
                'extend'=> 'csv',
                'text'=> 'Csv',
                'title'=> 'All JobCategory',
                'exportOptions' =>  [
                'columns' => [1,2,3],
                ],
                'footer'=> true,
                'autoPrint'=> true
            ],
            [
                'extend'=> 'excel',
                'text'=> 'Excel',
                'title'=> 'All JobCategory',
                'exportOptions' =>  [
                'columns' => [1,2,3],
                ],
                'footer'=> true,
                'autoPrint'=> true
            ],
            [
                'extend'=> 'pdf',
                'text'=> 'Pdf',
                'title'=> 'All JobCategory',
                'exportOptions' =>  [
                'columns' => [1,2,3],
                ],
                'footer'=> true,
                'autoPrint'=> true
            ],
            'colvis'
        ];
        return $this->builder()
                    ->setTableId('client-table')
                    ->columns($this->getColumns())
                    ->postAjax([
                        'url' => route('client.index'),
                        'data' => 'function(search) {
                            search._token = "{{ csrf_token() }}";
                            search.client_name = $("#client_name").val();
                            search.supervisor = $("#supervisor").val();
                            search.job_title = $("#job_title").val();
                            search.status = $("#status").val();
                        }'
                    ])
                    ->parameters([
                        'dom'          => 'Bfrtip',
                        'buttons'      => [ $print],
                        'stateSave' => true,//true,
                        'bScrollInfinite' => true,
                        'responsive' => true,
                        'lengthMenu' => [10, 15, 30, 50, 100],
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
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60),
            // Column::make('id'),
            Column::make('client_name') ,
            Column::make('client_address') ,
            Column::make('supervisor') ,
            // Column::make('job'),
            // Column::make('status'),
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
