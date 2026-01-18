<?php

namespace App\DataTables;

use App\Models\Hasil;
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

class HasilDataTable extends DataTable
{
    protected $start_date;
    protected $end_date;

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
                $sendRoute = route('hasil.edit', $item->uuid);
                $actionButton = "<div class='dropdown'>
                                    <button class='btn btn-sm btn-primary' title='Kirim Photo dan/atau Video via WA' data-bs-toggle='dropdown'>
                                        <i class='fa fa-paper-plane'></i>
                                        Kirim
                                    </button>

                                    <div class='dropdown-menu dropdown-menu-end'>
                                        <a class='dropdown-item' href='{$sendRoute}'>
                                            <i class='fa fa-paper-plane'></i>
                                            Kirim Hasil Pemeriksaan via WA
                                        </a>
                                    </div>
                                </div>";

                $photo = $item->medias->where('media_type', 'photo')->count();
                $video = $item->medias->where('media_type', 'video')->count();

                if($photo === 0 && $video === 0) {
                    return "";
                }

                return $actionButton;
            })
            ->addColumn('photo', function ($row) {
                $count = $row->medias->where('media_type', 'photo')->count();
                if ($count > 0) {
                    return '<span class="text-success">✔ '.$count.'</span>';
                }
                return '<span class="text-danger">✘</span>';
            })
            ->addColumn('video', function ($row) {
                $count = $row->medias->where('media_type', 'video')->count();
                if ($count > 0) {
                    return '<span class="text-success">✔ '.$count.'</span>';
                }
                return '<span class="text-danger">✘</span>';
            })
            ->addColumn('status_kirim', function ($item) {
                return null;
            })
            ->rawColumns(['#', 'photo', 'video']);
    }

    public function query(Pemeriksaan $model): QueryBuilder
    {
        $query = $model
            ->with(['pasien', 'pasien.gender', 'dokter', 'room', 'status_pemeriksaan', 'status_pembayaran'])
            ->where('status_pemeriksaan_id', 4) //status pemeriksaan closed
            ->where('status_pembayaran_id', 2) //status bayar lunas
            ->newQuery();

        // Filter
        if ($this->start_date != null && $this->end_date != null) {
            $clean_start_date = explode('?', $this->start_date)[0];
            $clean_end_date = explode('?', $this->end_date)[0];

            $start = Carbon::parse($clean_start_date)->startOfDay()->format('Y-m-d H:i:s');
            $end = Carbon::parse($clean_end_date)->endOfDay()->format('Y-m-d H:i:s');

            $query->whereBetween('datetime_registrasi', [$start, $end]);
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('hasil-table')
            ->columns($this->getColumns())
            ->ajax('')
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
            Column::make('code')->addClass('text-nowrap fw-bolder')->title('No. Registrasi'),
            Column::make('datetime_registrasi')->addClass('text-nowrap')->title('Tanggal Registrasi'),
            Column::make('pasien.name')->addClass('text-nowrap fw-bolder')->title('Nama Pasien'),
            Column::computed('photo')->addClass('text-nowrap text-center')->title('Photo .jpeg?'),
            Column::computed('video')->addClass('text-nowrap text-center')->title('Video .MP4?'),
            Column::make('status_pemeriksaan.name')->addClass('text-nowrap text-center')->title('Status Pemeriksaan'),
            Column::make('status_pembayaran.name')->addClass('text-nowrap text-center')->title('Status Bayar'),
            // Column::computed('status_kirim')->addClass('text-nowrap')->title('Terkirim WA?'),
        ];
    }

    protected function filename(): string
    {
        return 'Hasil_' . date('YmdHis');
    }
}
