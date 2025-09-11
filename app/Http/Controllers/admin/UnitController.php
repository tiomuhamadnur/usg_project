<?php

namespace App\Http\Controllers\admin;

use App\DataTables\UnitDataTable;
use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index(UnitDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.unit.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required|unique:unit,code'
        ]);

        Unit::updateOrCreate($data, $data);

        return redirect()->route('unit.index')->withNotify('Data berhasil ditambahkan');
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
        $data = Unit::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required'
        ]);

        $data->update($rawData);
        return redirect()->route('unit.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = Unit::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('unit.index')->withNotify('Data berhasil dihapus');
    }
}
