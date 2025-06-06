<?php

namespace App\DataTables;

use App\Models\Pemeriksaan;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PemeriksaanDokterDataTable extends DataTable
{
    protected $start_date;
    protected $end_date;
    protected $room_id;
    protected $status_pemeriksaan_id;
    protected $status_pembayaran_id;

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
            ->addColumn('#', function ($item) {
                $editRoute = route('pemeriksaan-dokter.edit', $item->uuid);
                $showRoute = route('pemeriksaan-dokter.show', $item->uuid);
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
                                    </div>
                                </div>";

                return $actionButton;
            })
            ->rawColumns(['#']);
    }

    public function query(Pemeriksaan $model): QueryBuilder
    {
        $query = $model
            ->with(['pasien', 'pasien.gender', 'dokter', 'room', 'status_pemeriksaan', 'status_pembayaran'])
            ->where('status_pemeriksaan_id', 2)
            ->newQuery();

        if (Auth::user()->role_id != 1) {
            $query->where('dokter_id', Auth::user()->id);
        }

        // Filter
        if($this->room_id != null)
        {
            $query->where('room_id', $this->room_id);
        }

        if($this->status_pemeriksaan_id != null)
        {
            $query->where('status_pemeriksaan_id', $this->status_pemeriksaan_id);
        }

        if($this->status_pembayaran_id != null)
        {
            $query->where('status_pembayaran_id', $this->status_pembayaran_id);
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
                    ->setTableId('pemeriksaandokter-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
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
                ->addClass('text-center text-nowrap'),
            Column::make('code')->addClass('text-nowrap fw-bolder')->title('Kode Registrasi'),
            Column::make('no_urut')->addClass('text-nowrap fw-bolder')->title('No Antrean'),
            Column::make('datetime')->addClass('text-nowrap')->title('Tanggal & Jam'),
            Column::make('pasien.name')->addClass('text-nowrap')->title('Nama Pasien'),
            Column::make('pasien.gender.name')->title('Jenis Kelamin'),
            Column::make('dokter.name')->addClass('text-nowrap')->title('Dokter'),
            Column::make('room.name')->title('Ruangan'),
            Column::make('status_pemeriksaan.name')->title('Status Pemeriksaan'),
            Column::make('status_pembayaran.name')->title('Status Pembayaran'),
        ];
    }

    protected function filename(): string
    {
        return 'PemeriksaanDokter_' . date('YmdHis');
    }
}
