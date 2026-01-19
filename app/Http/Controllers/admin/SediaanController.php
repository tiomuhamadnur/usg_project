<?php

namespace App\Http\Controllers\admin;

use App\DataTables\SediaanDataTable;
use App\Http\Controllers\Controller;
use App\Models\Sediaan;
use Illuminate\Http\Request;

class SediaanController extends Controller
{
    public function __construct()
    {
        // hanya index
        $this->middleware('permission:master.read')->only('index');

        // selain index
        $this->middleware('permission:master.write')
            ->except('index');
    }

    public function index(SediaanDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.sediaan.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required|unique:sediaan,code'
        ]);

        Sediaan::updateOrCreate($data, $data);

        return redirect()->route('sediaan.index')->withNotify('Data berhasil ditambahkan');
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
        $data = Sediaan::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required'
        ]);

        $data->update($rawData);
        return redirect()->route('sediaan.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = Sediaan::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('sediaan.index')->withNotify('Data berhasil dihapus');
    }
}
