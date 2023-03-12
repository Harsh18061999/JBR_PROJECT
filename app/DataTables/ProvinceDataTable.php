<?php

namespace App\DataTables;

use App\Models\Provience;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProvinceDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {   
        return (new EloquentDataTable($query))->rawColumns(['action'])
            ->addColumn('action', function($query){
                return view('content.province.action',compact('query'));
            })
            ->addColumn('country', function($query){
                return $query->country->name;            
            })
            ->addColumn('province', function($query){
                return $query->provience_name;            
            })
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Provience $model,Request $request): QueryBuilder
    { 
        if($request->provience_name && $request->provience_name != ''){
            $model = $model->where('provience_name',$request->provience_name);
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
                    ->setTableId('province-table')
                    ->columns($this->getColumns())
                    ->postAjax([
                        'url' => route('province.index'),
                        'data' => 'function(search) {
                            search._token = "{{ csrf_token() }}";
                            search.provience_name = $("#provience_name").val();
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
                        'scrollX' => true,
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
                  ->width(60)->addClass('text-center'),
            Column::make('country') ,
            Column::make('province') ,
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Province_' . date('YmdHis');
    }
}
