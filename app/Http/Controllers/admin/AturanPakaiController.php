<?php

namespace App\Http\Controllers\admin;

use App\DataTables\AturanPakaiDataTable;
use App\Http\Controllers\Controller;
use App\Models\AturanPakai;
use Illuminate\Http\Request;

class AturanPakaiController extends Controller
{
    public function index(AturanPakaiDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.aturan-pakai.index');
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

        AturanPakai::updateOrCreate($data, $data);

        return redirect()->route('aturan-pakai.index')->withNotify('Data berhasil ditambahkan');
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
        $data = AturanPakai::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required'
        ]);

        $data->update($rawData);
        return redirect()->route('aturan-pakai.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = AturanPakai::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('aturan-pakai.index')->withNotify('Data berhasil dihapus');
    }
}
