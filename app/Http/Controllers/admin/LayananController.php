<?php

namespace App\Http\Controllers\admin;

use App\DataTables\LayananDataTable;
use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index(LayananDataTable $dataTable)
    {
        $kategori = Kategori::all();
        return $dataTable->render('pages.admin.layanan.index', compact([
            'kategori',
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
            'code' => 'string|required|unique:layanan,code',
            "kategori_id" => "required|exists:kategori,id",
            "harga" => "required|numeric|min:1",
            "deskripsi" => "nullable|string",
        ]);

        Layanan::updateOrCreate($data, $data);

        return redirect()->route('layanan.index')->withNotify('Data berhasil ditambahkan');
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
        $data = Layanan::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required',
            "kategori_id" => "required|exists:kategori,id",
            "harga" => "required|numeric|min:1",
            "deskripsi" => "nullable|string",
        ]);

        $data->update($rawData);
        return redirect()->route('layanan.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = Layanan::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('layanan.index')->withNotify('Data berhasil dihapus');
    }
}
