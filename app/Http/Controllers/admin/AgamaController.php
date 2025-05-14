<?php

namespace App\Http\Controllers\admin;

use App\DataTables\AgamaDataTable;
use App\Http\Controllers\Controller;
use App\Models\Agama;
use Illuminate\Http\Request;

class AgamaController extends Controller
{
    public function index(AgamaDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.agama.index');
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

        Agama::updateOrCreate($data, $data);

        return redirect()->route('agama.index')->withNotify('Data berhasil ditambahkan');
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
        $data = Agama::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required'
        ]);

        $data->update($rawData);
        return redirect()->route('agama.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = Agama::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('agama.index')->withNotify('Data berhasil dihapus');
    }
}
