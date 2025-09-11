<?php

namespace App\Http\Controllers\admin;

use App\DataTables\ObatDataTable;
use App\Http\Controllers\Controller;
use App\Models\Obat;
use App\Models\Sediaan;
use App\Models\Unit;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index(ObatDataTable $dataTable)
    {
        $unit = Unit::orderBy('name', 'ASC')->get();
        $sediaan = Sediaan::orderBy('name', 'ASC')->get();
        return $dataTable->render('pages.admin.obat.index', compact([
            'unit',
            'sediaan',
        ]));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required|unique:obat,code',
            "stock" => "required|numeric|min:0",
            "unit_id" => "required|exists:unit,id",
            "sediaan_id" => "required|exists:unit,id",
            "harga_modal" => "required|numeric|min:1",
            "harga_jual" => "required|numeric|gte:harga_modal",
            "merk" => "nullable|string",
            "bpom" => "nullable|string",
            "kandungan" => "nullable|string",
            "deskripsi" => "nullable|string",
        ]);

        Obat::updateOrCreate($data, $data);

        return redirect()->route('obat.index')->withNotify('Data berhasil ditambahkan');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $uuid)
    {
        $data = Obat::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required',
            "stock" => "required|numeric|min:0",
            "unit_id" => "required|exists:unit,id",
            "sediaan_id" => "required|exists:unit,id",
            "harga_modal" => "required|numeric|min:1",
            "harga_jual" => "required|numeric|gte:harga_modal",
            "merk" => "nullable|string",
            "bpom" => "nullable|string",
            "kandungan" => "nullable|string",
            "deskripsi" => "nullable|string",
        ]);

        $data->update($rawData);
        return redirect()->route('obat.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = Obat::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('obat.index')->withNotify('Data berhasil dihapus');
    }
}
