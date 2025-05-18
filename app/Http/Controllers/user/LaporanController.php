<?php

namespace App\Http\Controllers\user;

use App\DataTables\LaporanDataTable;
use App\Http\Controllers\Controller;
use App\Models\MetodePembayaran;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(LaporanDataTable $dataTable, Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date|before_or_equal:end_date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'metode_pembayaran_id' => 'nullable',
        ], [
            'start_date.before_or_equal' => 'Tanggal awal harus <= tanggal akhir',
            'end_date.after_or_equal' => 'Tanggal akhir harus >= tanggal awal',
        ]);

        $start_date = $request->start_date ?? null;
        $end_date = $request->end_date ?? $start_date;
        $metode_pembayaran_id = $request->metode_pembayaran_id ?? null;

        $metode_pembayaran = MetodePembayaran::all();

        return $dataTable->with([
            'start_date' => $start_date,
            'end_date' => $end_date,
            'metode_pembayaran_id' => $metode_pembayaran_id,
        ])->render('pages.user.laporan.index', [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'metode_pembayaran_id' => $metode_pembayaran_id,
            'metode_pembayaran' => $metode_pembayaran,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $uuid)
    {
        //
    }

    public function edit(string $uuid)
    {
        //
    }

    public function update(Request $request, string $uuid)
    {
        //
    }

    public function destroy(string $uuid)
    {
        //
    }
}
