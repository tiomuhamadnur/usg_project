<?php

namespace App\Http\Controllers\user;

use App\DataTables\LogObatDataTable;
use App\Http\Controllers\Controller;
use App\Models\LogObat;
use App\Models\Obat;
use Illuminate\Http\Request;

class LogObatController extends Controller
{
    public function index(LogObatDataTable $dataTable, Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date|before_or_equal:end_date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'tipe' => 'nullable',
        ], [
            'start_date.before_or_equal' => 'Tanggal awal harus <= tanggal akhir',
            'end_date.after_or_equal' => 'Tanggal akhir harus >= tanggal awal',
        ]);

        $start_date = $request->start_date ?? null;
        $end_date = $request->end_date ?? $start_date;
        $tipe = $request->tipe ?? null;

        $obat = Obat::orderBy('name', 'ASC')->get();

        return $dataTable->with([
            'start_date' => $start_date,
            'end_date' => $end_date,
            'tipe' => $tipe,
        ])->render('pages.user.log-obat.index', compact([
            'start_date',
            'end_date',
            'tipe',
            'obat',
        ]));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $rawData = $request->validate([
            'tipe' => 'required|in:+,-',
            'obat_id' => 'required|exists:obat,id',
            'qty' => 'required|numeric|min:1',
            'catatan' => 'nullable|string',
        ]);

        $data = LogObat::create($rawData);

        return redirect()->route('log-obat.index')->withNotify('Data log obat <strong>' . $data->obat->name .'</strong> berhasil disimpan.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
