<?php

namespace App\DataTables;

use App\Models\Laporan;
use App\Models\Pemeriksaan;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LaporanDataTable extends DataTable
{
    protected $start_date;
    protected $end_date;
    protected $metode_pembayaran_id;

    public function with(array|string $key, mixed $value = null): static
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->{$k} = $v;
            }
        } else {
            $this->{$key} = $value;
        }

        return $this;
    }
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('total_bayar', function ($item) {
                return 'Rp. ' . number_format($item->total_bayar, 0, ',', '.');
            })
            ->addColumn('#', function ($item) {
                $editRoute = route('laporan.edit', $item->uuid);
                $showRoute = route('laporan.show', $item->uuid);
                $actionButton = "<div class='dropdown'>
                                    <button class='btn' data-bs-toggle='dropdown'>
                                        <i class='fa fa-pencil'></i>
                                        Edit
                                    </button>

                                    <div class='dropdown-menu dropdown-menu-end'>
                                        <a class='dropdown-item' href='{$editRoute}'>
                                            <i class='fa fa-pencil'></i>
                                            Edit
                                        </a>
                                        <a class='dropdown-item' href='{$showRoute}'>
                                            <i class='fa fa-eye'></i>
                                            Show
                                        </a>
                                    </div>
                                </div>";

                return $actionButton;
            })
            ->rawColumns(['#']);
    }

    public function query(Pemeriksaan $model): QueryBuilder
    {
        $query = $model
            ->with(['pasien', 'pasien.gender', 'dokter', 'room', 'status_pemeriksaan', 'status_pembayaran', 'metode_pembayaran'])
            ->where('status_pemeriksaan_id', 4) //status pemeriksaan closed
            ->where('status_pembayaran_id', 2) //status bayar lunas
            ->newQuery();

        // Filter
        if($this->metode_pembayaran_id != null)
        {
            $query->where('metode_pembayaran_id', $this->metode_pembayaran_id);
        }

        if ($this->start_date != null && $this->end_date != null) {
            $clean_start_date = explode('?', $this->start_date)[0];
            $clean_end_date = explode('?', $this->end_date)[0];

            $start = Carbon::parse($clean_start_date)->startOfDay()->format('Y-m-d H:i:s');
            $end = Carbon::parse($clean_end_date)->endOfDay()->format('Y-m-d H:i:s');

            $query->whereBetween('datetime', [$start, $end]);
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('laporan-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->pageLength(10)
                    ->lengthMenu([10, 50, 100, 250, 500, 1000])
                    //->dom('Bfrtip')
                    ->orderBy([2, 'desc'])
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
                ->addClass('text-center text-nowrap'),
            Column::make('code')->addClass('text-nowrap fw-bolder')->title('Kode Registrasi'),
            Column::make('datetime')->addClass('text-nowrap')->title('Tanggal & Jam'),
            Column::make('pasien.name')->addClass('text-nowrap')->title('Nama Pasien'),
            Column::computed('total_bayar')->addClass('text-nowrap')->title('Total Bayar'),
            Column::make('metode_pembayaran.name')->addClass('text-nowrap')->title('Metode Bayar'),
            Column::make('status_pembayaran.name')->title('Status Pembayaran'),
        ];
    }

    protected function filename(): string
    {
        return 'Laporan_' . date('YmdHis');
    }
}
