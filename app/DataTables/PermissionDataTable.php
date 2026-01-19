<?php

namespace App\DataTables;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Spatie\Permission\Models\Permission as ModelsPermission;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PermissionDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('#', function ($item) {
                $editRoute = route('permission.update', $item->id);
                $deleteRoute = route('permission.destroy', $item->id);
                $actionButton = "<div class='dropdown'>
                                    <button class='btn btn-sm btn-primary' data-bs-toggle='dropdown'>
                                        <i class='fa fa-pencil'></i>
                                        Edit
                                    </button>

                                    <div class='dropdown-menu dropdown-menu-end'>
                                        <a class='dropdown-item' href='#' data-bs-toggle='modal' data-bs-target='#editModal' data-url='{$editRoute}' data-name='{$item->name}'>
                                            <i class='fa fa-pencil'></i>
                                            Edit
                                        </a>
                                        <a class='dropdown-item text-danger' href='#' data-bs-toggle='modal' data-bs-target='#deleteModal' data-url='{$deleteRoute}'>
                                            <i class='fa fa-trash-can'></i>
                                            Delete
                                        </a>
                                    </div>
                                </div>";

                return $actionButton;
            })
            ->rawColumns(['#']);
    }

    public function query(ModelsPermission $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('permission-table')
                    ->columns($this->getColumns())
                    ->ajax('')
                    ->pageLength(10)
                    ->lengthMenu([10, 50, 100, 250, 500, 1000])
                    ->orderBy([0, 'asc'])
                    ->selectStyleSingle()
                    ->buttons([
                        [
                            'extend' => 'excel',
                            'text' => 'Export to Excel',
                            'attr' => [
                                'id' => 'datatable-excel',
                                'style' => 'display: none;',
                            ],
                        ],
                    ]);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('#')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
            Column::make('name')->title('Name'),
        ];
    }

    protected function filename(): string
    {
        return 'Permission_' . date('YmdHis');
    }
}
