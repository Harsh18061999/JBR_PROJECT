<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
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
    public function query(User $model,Request $request): QueryBuilder
    {
        // dd($request->all());
        if($request->user_name && $request->user_name != ''){
            $model = $model->where('id',$request->user_name);
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
        return $this->builder()
                    ->setTableId('user-table')
                    ->columns($this->getColumns())
                    ->postAjax([
                        'url' => route('user.index'),
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
            // Column::make('id'),
            Column::make('name') ,
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
