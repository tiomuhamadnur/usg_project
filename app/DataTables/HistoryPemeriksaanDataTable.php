<?php

namespace App\DataTables;

use App\Models\Pemeriksaan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class HistoryPemeriksaanDataTable extends DataTable
{
    protected $pasien_uuid;

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
                // gabung obats jadi "NamaObat (dosis)"
                $obats = $item->obats->isNotEmpty()
                    ? $item->obats->map(function ($i) {
                        return optional($i->obat)->name
                            . ($i->dosis ? ' | Dosis: ' . $i->dosis : '')
                            . ($i->aturan_pakai ? ' | Aturan: ' . $i->aturan_pakai : '')
                            . ($i->jumlah ? ' | Jumlah: ' . $i->jumlah : '')
                            . ($i->catatan_obat ? ' | Catatan: ' . $i->catatan_obat : '');
                    })->implode('; ')
                    : '-';

                // gabung layanans jadi "NamaLayanan (Kategori)"
                $layanans = $item->layanans->map(function ($layanan) {
                    return $layanan->layanan->name . ' (' . $layanan->layanan->kategori->name . ')';
                })->implode(', ');

                $actionButton = "<div class='text-primary'>
                    <button class='btn' data-bs-toggle='modal' data-bs-target='#showModal'
                        data-name=\"" . e(optional($item->pasien)->name) . "\"
                        data-gender=\"" . e(optional(optional($item->pasien)->gender)->name) . "\"
                        data-umur=\"" . e(($item->pasien->umur->tahun ?? 0) . " tahun, " . ($item->pasien->umur->bulan ?? 0) . " bulan, " . ($item->pasien->umur->hari ?? 0) . " hari") . "\"
                        data-tanggal-lahir=\"" . e(optional($item->pasien)->tanggal_lahir) . "\"
                        data-datetime=\"" . e($item->datetime ?? '') . "\"
                        data-room=\"" . e(optional($item->room)->name) . "\"
                        data-dokter=\"" . e(optional($item->dokter)->name) . "\"
                        data-rencana-pasien=\"" . e($item->rencana_pasien ?? '') . "\"
                        data-keluhan-pasien=\"" . e($item->keluhan_pasien ?? '') . "\"
                        data-alergi-obat=\"" . e($item->alergi_obat ?? '') . "\"
                        data-alergi-makanan=\"" . e($item->alergi_makanan ?? '') . "\"
                        data-nadi=\"" . e($item->nadi ?? '') . "\"
                        data-temperatur=\"" . e($item->temperatur ?? '') . "\"
                        data-napas=\"" . e($item->napas ?? '') . "\"
                        data-tekanan-darah-systolic=\"" . e($item->tekanan_darah_systolic ?? '') . "\"
                        data-tekanan-darah-diastolic=\"" . e($item->tekanan_darah_diastolic ?? '') . "\"
                        data-tinggi-badan=\"" . e($item->tinggi_badan ?? '') . "\"
                        data-berat-badan=\"" . e($item->berat_badan ?? '') . "\"
                        data-lingkar-perut=\"" . e($item->lingkar_perut ?? '') . "\"
                        data-keluhan-utama=\"" . e($item->keluhan_utama ?? '') . "\"
                        data-keluhan-tambahan=\"" . e($item->keluhan_tambahan ?? '') . "\"
                        data-diagnosa-utama=\"" . e($item->diagnosa_utama ?? '') . "\"
                        data-diagnosa-sekunder=\"" . e($item->diagnosa_sekunder ?? '') . "\"
                        data-hasil-pemeriksaan=\"" . e($item->hasil_pemeriksaan ?? '') . "\"
                        data-terapi-obat=\"" . e($obats) . "\"
                        data-layanan=\"" . e($layanans) . "\"
                        data-saran=\"" . e($item->saran ?? '') . "\"
                        data-resep-dokter=\"" . e($item->resep_dokter ?? '') . "\"
                        data-tindakan=\"" . e($item->tindakan ?? '') . "\"
                        data-rujukan=\"" . e($item->rujukan ?? '') . "\"
                    >
                        <i class='fa fa-eye'></i> Show
                    </button>
                </div>";

                return $actionButton;
            })
            ->rawColumns(['#']);

    }

    public function query(Pemeriksaan $model): QueryBuilder
    {
        $query = $model
            ->with(['pasien', 'pasien.gender', 'dokter', 'room', 'status_pemeriksaan', 'status_pembayaran'])
            ->whereRelation('pasien', 'uuid', '=', $this->pasien_uuid)
            ->where('status_pemeriksaan_id', 4) //status pemeriksaan closed
            ->newQuery();

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('historypemeriksaan-table')
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
            Column::make('code')->addClass('text-nowrap fw-bolder')->title('Kode Registrasi'),
            Column::make('datetime')->addClass('text-nowrap')->title('Tanggal & Jam'),
            Column::make('pasien.name')->addClass('text-nowrap')->title('Nama Pasien'),
            Column::make('pasien.gender.name')->title('Jenis Kelamin'),
            Column::make('dokter.name')->addClass('text-nowrap')->title('Dokter'),
            // Column::make('room.name')->title('Ruangan'),
            Column::make('status_pemeriksaan.name')->title('Status Pemeriksaan'),
            Column::make('status_pembayaran.name')->title('Status Pembayaran'),
        ];
    }

    protected function filename(): string
    {
        return 'HistoryPemeriksaan_' . date('YmdHis');
    }
}
