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
                    $actionButton = "<div class='text-primary'>
                        <button class='btn' data-bs-toggle='modal' data-bs-target='#showModal'
                            data-name=\"{$item->pasien->name}\"
                            data-gender=\"{$item->pasien->gender->name}\"
                            data-umur=\"{$item->pasien->umur->tahun} tahun, {$item->pasien->umur->bulan} bulan, {$item->pasien->umur->hari} hari\"
                            data-tanggal-lahir=\"{$item->pasien->tanggal_lahir}\"
                            data-datetime=\"{$item->datetime}\"
                            data-room=\"{$item->room->name}\"
                            data-dokter=\"{$item->dokter->name}\"
                            data-rencana-pasien=\"{$item->rencana_pasien}\"
                            data-keluhan-pasien=\"{$item->keluhan_pasien}\"
                            data-alergi-obat=\"{$item->alergi_obat}\"
                            data-alergi-makanan=\"{$item->alergi_makanan}\"
                            data-nadi=\"{$item->nadi}\"
                            data-temperatur=\"{$item->temperatur}\"
                            data-napas=\"{$item->napas}\"
                            data-tekanan-darah-systolic=\"{$item->tekanan_darah_systolic}\"
                            data-tekanan-darah-diastolic=\"{$item->tekanan_darah_diastolic}\"
                            data-tinggi-badan=\"{$item->tinggi_badan}\"
                            data-berat-badan=\"{$item->berat_badan}\"
                            data-lingkar-perut=\"{$item->lingkar_perut}\"
                            data-keluhan-utama=\"{$item->keluhan_utama}\"
                            data-keluhan-tambahan=\"{$item->keluhan_tambahan}\"
                            data-diagnosa-utama=\"{$item->diagnosa_utama}\"
                            data-diagnosa-sekunder=\"{$item->diagnosa_sekunder}\"
                            data-hasil-pemeriksaan=\"{$item->hasil_pemeriksaan}\"
                            data-terapi-obat=\"{$item->terapi_obat}\"
                            data-saran=\"{$item->saran}\"
                            data-resep-dokter=\"{$item->resep_dokter}\"
                            data-tindakan=\"{$item->tindakan}\"
                            data-rujukan=\"{$item->rujukan}\"
                        >
                            <i class='fa fa-eye'></i> Show
                        </button>
                    </div>";

                    return $actionButton;
                })
                ->rawColumns(['#']);;
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
            Column::make('pasien.gender.name')->title('Jenis Kelamin'),
            Column::make('dokter.name')->addClass('text-nowrap')->title('Dokter'),
            Column::make('room.name')->title('Ruangan'),
            Column::make('status_pemeriksaan.name')->title('Status Pemeriksaan'),
            Column::make('status_pembayaran.name')->title('Status Pembayaran'),
        ];
    }

    protected function filename(): string
    {
        return 'HistoryPemeriksaan_' . date('YmdHis');
    }
}
