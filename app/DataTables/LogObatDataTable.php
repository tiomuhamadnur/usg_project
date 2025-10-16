<?php

namespace App\DataTables;

use App\Models\LogObat;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LogObatDataTable extends DataTable
{
    protected $start_date;
    protected $end_date;
    protected $tipe;

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
            ->addColumn('tipe', function ($item) {
                $color = $item->tipe === '+' ? 'success' : 'danger';
                $value = $item->tipe === '+' ? 'IN' : 'OUT';
                return "<span class='badge bg-{$color}' fw-bolder fs-2 px-3 py-2>{$value}</span>";
            })
            ->editColumn('created_at', function ($item) {
                return $item->created_at
                    ? $item->created_at->format('Y-m-d H:i:s')
                    : '-';
            })
            ->rawColumns(['tipe']);
    }

    public function query(LogObat $model): QueryBuilder
    {
        $query = $model
            ->with(['obat.sediaan', 'user', 'pemeriksaan'])
            ->newQuery();

        // Filter
        if($this->tipe != null)
        {
            $query->where('tipe', $this->tipe);
        }

        if ($this->start_date != null && $this->end_date != null) {
            $clean_start_date = explode('?', $this->start_date)[0];
            $clean_end_date = explode('?', $this->end_date)[0];

            $start = Carbon::parse($clean_start_date)->startOfDay()->format('Y-m-d H:i:s');
            $end = Carbon::parse($clean_end_date)->endOfDay()->format('Y-m-d H:i:s');

            $query->whereBetween('created_at', [$start, $end]);
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('logobat-table')
                    ->columns($this->getColumns())
                    ->ajax('')
                    ->pageLength(10)
                    ->lengthMenu([10, 50, 100, 250, 500, 1000])
                    ->orderBy([6, 'desc'])
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
            Column::computed('tipe')
                ->title('Tipe Transaksi')
                ->addClass('text-center'),
            Column::make('obat.name')->title('Nama Obat'),
            Column::make('obat.code')->title('Kode Obat'),
            Column::make('obat.sediaan.name')->title('Sediaan'),
            Column::make('qty')->title('Qty')->addClass('text-center'),
            Column::make('pemeriksaan.code')->title('No. Registrasi'),
            Column::make('catatan')->title('Catatan'),
            Column::make('created_at')->title('Created At'),
            Column::make('user.name')->title('Created By'),
        ];
    }

    protected function filename(): string
    {
        return 'LogObat_' . date('YmdHis');
    }
}
