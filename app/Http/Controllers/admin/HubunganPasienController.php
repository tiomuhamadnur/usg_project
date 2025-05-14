<?php

namespace App\Http\Controllers\admin;

use App\DataTables\HubunganPasienDataTable;
use App\Http\Controllers\Controller;
use App\Models\HubunganPasien;
use Illuminate\Http\Request;

class HubunganPasienController extends Controller
{
    public function index(HubunganPasienDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.hubungan-pasien.index');
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

        HubunganPasien::updateOrCreate($data, $data);

        return redirect()->route('hubungan-pasien.index')->withNotify('Data berhasil ditambahkan');
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
        $data = HubunganPasien::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'name' => 'string|required',
        ]);

        $data->update($rawData);
        return redirect()->route('hubungan-pasien.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = HubunganPasien::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('hubungan-pasien.index')->withNotify('Data berhasil dihapus');
    }
}
