<?php

namespace App\DataTables;

use App\Models\Layanan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LayananDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('#', function ($item) {
                $editRoute = route('layanan.update', $item->uuid);
                $deleteRoute = route('layanan.destroy', $item->uuid);
                $actionButton = "<div class='dropdown'>
                                    <button class='btn btn-sm btn-primary' data-bs-toggle='dropdown'>
                                        <i class='fa fa-pencil'></i>
                                        Edit
                                    </button>

                                    <div class='dropdown-menu dropdown-menu-end'>
                                        <a class='dropdown-item' href='#' data-bs-toggle='modal' data-bs-target='#editModal'
                                        data-url='{$editRoute}'
                                        data-name='{$item->name}'
                                        data-code='{$item->code}'
                                        data-harga='{$item->harga}'
                                        data-kategori_id='{$item->kategori_id}'
                                        data-deskripsi='{$item->deskripsi}'>
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

    public function query(Layanan $model): QueryBuilder
    {
        $query = $model
            ->with(['kategori'])
            ->newQuery();

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('layanan-table')
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
            Column::make('code')->title('Code'),
            Column::make('harga')->title('Harga (Rp)'),
            Column::make('kategori.code')->title('Kategori'),
            Column::make('deskripsi')->title('Deskripsi')->addClass('text-wrap'),
        ];
    }

    protected function filename(): string
    {
        return 'Layanan_' . date('YmdHis');
    }
}
