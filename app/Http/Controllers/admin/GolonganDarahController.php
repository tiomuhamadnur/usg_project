<?php

namespace App\Http\Controllers\admin;

use App\DataTables\GolonganDarahDataTable;
use App\Http\Controllers\Controller;
use App\Models\GolonganDarah;
use Illuminate\Http\Request;

class GolonganDarahController extends Controller
{
    public function index(GolonganDarahDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.golongan-darah.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required',
        ]);

        GolonganDarah::updateOrCreate($data, $data);

        return redirect()->route('golongan-darah.index')->withNotify('Data berhasil ditambahkan');
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
        $data = GolonganDarah::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'name' => 'string|required',
        ]);

        $data->update($rawData);
        return redirect()->route('golongan-darah.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = GolonganDarah::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('golongan-darah.index')->withNotify('Data berhasil dihapus');
    }
}
