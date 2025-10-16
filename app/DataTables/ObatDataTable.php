<?php

namespace App\DataTables;

use App\Models\Obat;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ObatDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('#', function ($item) {
                $editRoute = route('obat.update', $item->uuid);
                $deleteRoute = route('obat.destroy', $item->uuid);
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
                                        data-stock='{$item->stock}'
                                        data-unit_id='{$item->unit_id}'
                                        data-sediaan_id='{$item->sediaan_id}'
                                        data-harga_modal='{$item->harga_modal}'
                                        data-harga_jual='{$item->harga_jual}'
                                        data-merk='{$item->merk}'
                                        data-bpom='{$item->bpom}'
                                        data-kandungan='{$item->kandungan}'
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

    public function query(Obat $model): QueryBuilder
    {
        $query = $model
            ->with(['unit', 'sediaan'])
            ->newQuery();

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('obat-table')
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
            Column::make('stock')->title('Stock'),
            Column::make('unit.code')->title('Unit'),
            Column::make('sediaan.code')->title('Sediaan'),
            Column::make('harga_modal')->title('Harga Modal'),
            Column::make('harga_jual')->title('Harga Jual'),
            Column::make('merk')->title('Merk'),
            Column::make('deskripsi')->title('Deskripsi')->addClass('text-wrap'),
            Column::make('kandungan')->title('Kandungan')->addClass('text-wrap'),
            Column::make('bpom')->title('BPOM'),
        ];
    }

    protected function filename(): string
    {
        return 'Obat_' . date('YmdHis');
    }
}
