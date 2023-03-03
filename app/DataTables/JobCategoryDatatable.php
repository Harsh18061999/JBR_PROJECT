<?php

namespace App\DataTables;

use App\Models\JobCategory;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class JobCategoryDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))->rawColumns(['license'])
            ->addColumn('action', function($query){
                return view("content.jobcategory.action",compact('query'));
                // return '<div>
                //             <a data-href="'.route('job_category.edit',$query->id).'" data-editurl="'.route('job_category.update',$query->id).'" class="pointer edit"><i class="fa-solid fa-pen-to-square mx-2"></i></a>
                //             <a data-href="'.route('job_category.destroy',$query->id).'" data-id="'.$query->id.'" class="delete pointer text-danger"><i class="fa-solid fa-trash"></i></a>
                //         </div>';
            })->addColumn('license', function($query){
                if($query->license_status == 1){
                    return '<span class="badge bg-label-success me-1">Required</span>';
                }else{
                    return '<span class="badge bg-label-danger me-1">Not Required</span>';
                }
            })->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(JobCategory $model): QueryBuilder
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
                'columns' => [1,2],
                ],
                'footer'=> true,
                'autoPrint'=> true
            ],
            [
                'extend'=> 'csv',
                'text'=> 'Csv',
                'title'=> 'All JobCategory',
                'exportOptions' =>  [
                'columns' => [1,2],
                ],
                'footer'=> true,
                'autoPrint'=> true
            ],
            [
                'extend'=> 'excel',
                'text'=> 'Excel',
                'title'=> 'All JobCategory',
                'exportOptions' =>  [
                'columns' => [1,2],
                ],
                'footer'=> true,
                'autoPrint'=> true
            ],
            'colvis'
        ];
        return $this->builder()
                    ->setTableId('job-category-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->parameters([
                        'dom'          => 'Bfrtip',
                        'buttons'      => [ $print],
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
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
            // Column::make('id'),
            Column::make('job_title') ->addClass('text-left'),
            Column::make('license') ->addClass('text-left')
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
