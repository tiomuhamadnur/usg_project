<?php

namespace App\Http\Controllers\admin;

use App\DataTables\KategoriDataTable;
use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(KategoriDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.kategori.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required|unique:kategori,code'
        ]);

        Kategori::updateOrCreate($data, $data);

        return redirect()->route('kategori.index')->withNotify('Data berhasil ditambahkan');
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
        $data = Kategori::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required'
        ]);

        $data->update($rawData);
        return redirect()->route('kategori.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = Kategori::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('kategori.index')->withNotify('Data berhasil dihapus');
    }
}
