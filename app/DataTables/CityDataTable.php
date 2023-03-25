<?php

namespace App\DataTables;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;   
use Yajra\DataTables\Services\DataTable;

class CityDataTable extends DataTable
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
                return view('content.city.action',compact('query'));
            })
            ->addColumn('province', function($query){
                return $query->province->provience_name;            
            })
            ->addColumn('city', function($query){
                return $query->city_title;    
            })
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(City $model,Request $request): QueryBuilder
    {
        if($request->city_title && $request->city_title != ''){
            $model = $model->where('city_title',$request->city_title);
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
                    ->setTableId('city-table')
                    ->columns($this->getColumns())
                    ->postAjax([
                        'url' => route('city.index'),
                        'data' => 'function(search) {
                            search._token = "{{ csrf_token() }}";
                            search.city_title = $("#city_title").val();
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
            Column::make('province') ,
            Column::make('city') ,
        ];
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
