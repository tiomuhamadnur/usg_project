<?php

namespace App\DataTables;

// use App\Models\Role;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Spatie\Permission\Models\Role as ModelsRole;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RoleDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('#', function ($item) {
                $editRoute = route('role.update', $item->id);
                $permissionNames = $item->permissions->pluck('name')->toArray();
                $permissionsJson = htmlspecialchars(json_encode($permissionNames), ENT_QUOTES, 'UTF-8');

                $editButton = "
                <button class='btn btn-outline-primary'
                        data-bs-toggle='modal' data-bs-target='#editModal'
                        data-url='{$editRoute}'
                        data-name='{$item->name}'
                        data-permissions='{$permissionsJson}'>
                    <i class='fa fa-edit'></i>
                </button>";

                $deleteRoute = route('role.destroy', $item->id);
                $deleteButton = "
                    <a href='javascript:void(0);' class='btn btn-outline-danger' data-bs-toggle='modal'
                    data-bs-target='#deleteModal' data-url='{$deleteRoute}'>
                        <i class='fa fa-trash'></i>
                    </a>";

                return $editButton . ' ' . $deleteButton;
            })
            ->addColumn('permission', function ($item) {
                if ($item->permissions->isEmpty()) {
                    return "<em class='text-muted'>Tidak ada</em>";
                }

                $html = "<ul style='padding-left:18px; margin:0; list-style-type: disc !important;'>";

                foreach ($item->permissions as $perm) {
                    $html .= "<li>{$perm->name}</li>";
                }

                $html .= "</ul>";

                return $html;
            })
            ->rawColumns(['#', 'permission']);
    }

    public function query(ModelsRole $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('role-table')
                    ->columns($this->getColumns())
                    ->ajax('')
                    ->pageLength(10)
                    ->lengthMenu([10, 50, 100, 250, 500, 1000])
                    //->dom('Bfrtip')
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
            Column::computed('permission')->title('Permissions'),
        ];
    }

    protected function filename(): string
    {
        return 'Role_' . date('YmdHis');
    }
}
