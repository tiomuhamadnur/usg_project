<?php

namespace App\DataTables;

use App\Models\LogDiskon;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LogDiskonDataTable extends DataTable
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
        return (new EloquentDataTable($query));
            // ->addColumn('action', 'logdiskon.action')
            // ->setRowId('id');
    }

    public function query(LogDiskon $model): QueryBuilder
    {
        $query = $model
            ->with([
                'pemeriksaan.pasien',
                'diskon',
            ])
            ->newQuery();

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
                    ->setTableId('logdiskon-table')
                    ->columns($this->getColumns())
                    ->ajax('')
                    ->pageLength(10)
                    ->lengthMenu([10, 50, 100, 250, 500, 1000])
                    ->orderBy([0, 'desc'])
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
            Column::make('pemeriksaan.datetime_invoice')->title('Tanggal'),
            Column::make('pemeriksaan.pasien.name')->title('Nama Pasien'),
            Column::make('pemeriksaan.code')->title('No. Registrasi'),
            Column::make('diskon.name')->title('Nama Diskon'),
            Column::make('diskon.harga')->title('Potongan (Rp)'),
        ];
    }

    protected function filename(): string
    {
        return 'LogDiskon_' . date('YmdHis');
    }
}
