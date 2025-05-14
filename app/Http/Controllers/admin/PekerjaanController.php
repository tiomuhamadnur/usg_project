<?php

namespace App\Http\Controllers\admin;

use App\DataTables\PekerjaanDataTable;
use App\Http\Controllers\Controller;
use App\Models\Pekerjaan;
use Illuminate\Http\Request;

class PekerjaanController extends Controller
{
    public function index(PekerjaanDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.pekerjaan.index');
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

        Pekerjaan::updateOrCreate($data, $data);

        return redirect()->route('pekerjaan.index')->withNotify('Data berhasil ditambahkan');
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
        $data = Pekerjaan::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'name' => 'string|required',
        ]);

        $data->update($rawData);
        return redirect()->route('pekerjaan.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = Pekerjaan::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('pekerjaan.index')->withNotify('Data berhasil dihapus');
    }
}
