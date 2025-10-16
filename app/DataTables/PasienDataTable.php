<?php

namespace App\DataTables;

use App\Models\Pasien;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PasienDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('#', function ($item) {
                $registrasiRoute = route('registrasi.create', ['uuid' => $item->uuid]);
                $editRoute = route('pasien.edit', $item->uuid);
                $deleteRoute = route('pasien.destroy', $item->uuid);
                $actionButton = "<div class='dropdown'>
                                    <button class='btn btn-sm btn-primary' data-bs-toggle='dropdown'>
                                        <i class='fa fa-eye'></i>
                                        Lihat
                                    </button>

                                    <div class='dropdown-menu dropdown-menu-end'>
                                        <a class='dropdown-item' href='{$registrasiRoute}'>
                                            <i class='fa fa-book'></i>
                                            Tambahkan Registrasi
                                        </a>
                                        <a class='dropdown-item' href='{$editRoute}'>
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
            ->addColumn('riwayat', function ($item) {
                $historyRoute = route('registrasi.index', ['pasien_uuid' => $item->uuid]);
                $actionButton = "<a class='btn btn-sm btn-success' href='{$historyRoute}'>
                                    <i class='fa fa-rectangle-list'></i>
                                    Riwayat
                                </a>";

                return $actionButton;
            })
            ->addColumn('umur', function ($item) {
                $umur = $item->umur->tahun . ' Tahun ' . $item->umur->bulan . ' Bulan ' . $item->umur->hari . ' hari';
                return $umur;
            })
            ->rawColumns(['umur', 'riwayat', '#']);
    }

    public function query(Pasien $model): QueryBuilder
    {
        $query = $model->with([
            'gender',
        ])->newQuery();

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('pasien-table')
                    ->columns($this->getColumns())
                    ->ajax('')
                    ->pageLength(10)
                    ->lengthMenu([10, 50, 100, 250, 500, 1000])
                    //->dom('Bfrtip')
                    ->orderBy([2, 'asc'])
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
            Column::computed('riwayat')->title('Riwayat')->addClass('text-center'),
            Column::make('name')->title('Nama Lengkap')->addClass('fw-bolder'),
            Column::make('member_code')->title('Kode Member'),
            Column::make('gender.name')->title('Jenis Kelamin'),
            Column::make('no_hp')->title('No HP/WA'),
            Column::make('tanggal_lahir')->title('Tanggal Lahir'),
            // Column::computed('umur')->title('Umur')->addClass('text-wrap'),
            Column::make('nik')->title('NIK KTP'),
        ];
    }

    protected function filename(): string
    {
        return 'Pasien_' . date('YmdHis');
    }
}
