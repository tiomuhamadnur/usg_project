<?php

namespace App\Http\Controllers\admin;

use App\DataTables\DiskonDataTable;
use App\Http\Controllers\Controller;
use App\Models\Diskon;
use Illuminate\Http\Request;

class DiskonController extends Controller
{
    public function __construct()
    {
        // hanya index
        $this->middleware('permission:master.read')->only('index');

        // selain index
        $this->middleware('permission:master.write')
            ->except('index');
    }

    public function index(DiskonDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.diskon.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $rawData = $request->validate([
            "name" => "string|required",
            "code" => "string|required|unique:diskon,code",
            "deskripsi" => "string|nullable|max:255",
            "harga" => "required|integer|min:1",
            "tanggal_awal" => "required|date",
            "tanggal_akhir" => "required|date|after_or_equal:tanggal_awal",
        ]);

        $data = Diskon::updateOrCreate($rawData, $rawData);

        return redirect()->route('diskon.index')->withNotify("Data diskon <b>{$data->name}</b> berhasil ditambahkan");
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
        $data = Diskon::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            "name" => "string|required",
            "code" => "string|required|unique:diskon,code," . $data->uuid . ",uuid",
            "deskripsi" => "string|nullable|max:255",
            "harga" => "required|integer|min:1",
            "tanggal_awal" => "required|date",
            "tanggal_akhir" => "required|date|after_or_equal:tanggal_awal",
        ]);

        $data->update($rawData);

        return redirect()->route('diskon.index')->withNotify("Data diskon <b>{$data->name}</b> berhasil diperbaharui");
    }

    public function destroy(string $uuid)
    {
        $data = Diskon::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('diskon.index')->withNotify('Data berhasil dihapus');
    }
}
