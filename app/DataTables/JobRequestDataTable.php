<?php

namespace App\DataTables;

use App\Models\JobRequest;
use App\Models\Client;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class JobRequestDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query,Request $request): EloquentDataTable
    {
        return (new EloquentDataTable($query))->rawColumns(['action','status','supervisor','client','job'])
            ->addColumn('action', function($query){
                return view('content.jobRequest.action',compact('query'));
            })
            ->addColumn('client', function($query){
                return isset($query->supervisor->client) ? $query->supervisor->client->client_name : null;
            })
            ->addColumn('supervisor', function($query){
                return isset($query->supervisor) ? $query->supervisor->supervisor : null;
            })
            ->addColumn('job', function($query){
                return $query->jobCategory->job_title;
            })
            ->addColumn('status', function($query){
                if($query->status == 0){
                    return '<span class="badge bg-label-primary me-1">Pending</span>';
                }else if($query->status == 1){
                    return '<span class="badge bg-label-warning me-1">On Going</span>';
                }else if($query->status == 2){
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
    public function query(JobRequest $model,Request $request): QueryBuilder
    {
        $role = auth()->user()->getRoleNames()->toArray();
        $role_name = isset($role[0]) ? $role[0] : '';
        if($role_name != "admin"){
            if($request->supervisor && $request->supervisor != ''){
                $model = $model->where('supervisor_id',$request->supervisor);
            }else{
                $supervisor_id = Supervisor::where('client_id',auth()->user()->client_id)->pluck('id')->toArray();
                $model = $model->whereIn('supervisor_id',$supervisor_id);
            }
        }
        if($request->job_date && $request->job_date != '' && $request->end_date && $request->end_date){
            $model = $model->where('job_date','>=',$request->job_date)
                ->where('end_date','<=',$request->end_date);
        }

        if($request->supervisor && $request->supervisor != ''){
            $model = $model->where('supervisor_id',$request->supervisor);
        }else if($request->client_name && $request->client_name != ''){
            $client_id = Supervisor::where('client_id',$request->client_name)->pluck('id')->toArray();
            $model = $model->whereIn('supervisor_id',$client_id);
        }

        if($request->job_id && $request->job_id != ''){
            $model = $model->where('job_id',$request->job_id);
        }

        if($request->status && $request->status != ''){
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
        $print = [
            [
                'extend'=> 'print',
                'text'=> 'Print',
                'title'=> 'All JobCategory',
                'exportOptions' =>  [
                'columns' => [1,2,3,4,5],
                ],
                'footer'=> true,
                'autoPrint'=> true
            ],
            [
                'extend'=> 'csv',
                'text'=> 'CSV',
                'title'=> 'All JobCategory',
                'exportOptions' =>  [
                'columns' => [1,2,3,4,5],
                ],
                'footer'=> true,
                'autoPrint'=> true
            ],
            [
                'extend'=> 'excel',
                'text'=> 'Excel',
                'title'=> 'All JobCategory',
                'exportOptions' =>  [
                'columns' => [1,2,3,4,5],
                ],
                'footer'=> true,
                'autoPrint'=> true
            ],
            [
                'extend'=> 'pdf',
                'text'=> 'PDF',
                'title'=> 'All JobCategory',
                'exportOptions' =>  [
                'columns' => [1,2,3,4,5],
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
                    ->setTableId('job-request-table')
                    ->columns($this->getColumns())
                    ->postAjax([
                        'url' => route('job_request.index'),
                        'data' => 'function(search) {
                            search._token = "{{ csrf_token() }}";
                            search.job_date = $("#job_date").val();
                            search.end_date = $("#end_date").val();
                            search.client_name = $("#client_name").val();
                            search.supervisor = $("#supervisor").val();
                            search.job_id = $("#job_title").val();
                            search.status = $("#status").val();
                        }'
                    ])
                    
                    ->parameters([
                        'dom'          => 'Bfrtip',
                        'buttons'      => [ $print],
                    ])
                   ->orderBy([4,'desc'])
                    ->responsive(true)->addTableClass('stripe row-border order-column gy-5 gs-7 border');
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
                  ->sortable(false)
                  ->width(60),
            Column::make('client'),
            Column::make('supervisor')->sortable(false),
            Column::make('job')->sortable(false),
            Column::make('job_date'),
            Column::make('end_date'),
            Column::make('status') ->sortable(false),
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
