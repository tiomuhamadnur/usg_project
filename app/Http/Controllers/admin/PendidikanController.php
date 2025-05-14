<?php

namespace App\Http\Controllers\admin;

use App\DataTables\PendidikanDataTable;
use App\Http\Controllers\Controller;
use App\Models\Pendidikan;
use Illuminate\Http\Request;

class PendidikanController extends Controller
{
    public function index(PendidikanDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.pendidikan.index');
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

        Pendidikan::updateOrCreate($data, $data);

        return redirect()->route('pendidikan.index')->withNotify('Data berhasil ditambahkan');
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
        $data = Pendidikan::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required'
        ]);

        $data->update($rawData);
        return redirect()->route('pendidikan.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = Pendidikan::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('pendidikan.index')->withNotify('Data berhasil dihapus');
    }
}
