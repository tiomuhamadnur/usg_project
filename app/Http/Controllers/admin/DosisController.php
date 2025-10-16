<?php

namespace App\Http\Controllers\admin;

use App\DataTables\DosisDataTable;
use App\Http\Controllers\Controller;
use App\Models\Dosis;
use Illuminate\Http\Request;

class DosisController extends Controller
{
    public function index(DosisDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.dosis.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required'
        ]);

        Dosis::updateOrCreate($data, $data);

        return redirect()->route('dosis.index')->withNotify('Data berhasil ditambahkan');
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
        $data = Dosis::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required'
        ]);

        $data->update($rawData);
        return redirect()->route('dosis.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = Dosis::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('dosis.index')->withNotify('Data berhasil dihapus');
    }
}
