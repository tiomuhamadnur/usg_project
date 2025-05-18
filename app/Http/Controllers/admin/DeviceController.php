<?php

namespace App\Http\Controllers\admin;

use App\DataTables\DeviceDataTable;
use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Room;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index(DeviceDataTable $dataTable)
    {
        $room = Room::all();
        return $dataTable->render('pages.admin.device.index', [
            'room' => $room,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required',
            'ip_address' => 'required|ip',
            'username' => 'string|required',
            'password' => 'string|required',
            'room_id' => 'required|numeric|exists:room,id',
        ]);

        Device::updateOrCreate($data, $data);

        return redirect()->route('device.index')->withNotify('Data berhasil ditambahkan');
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
        $data = Device::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            'name' => 'string|required',
            'code' => 'string|required',
            'ip_address' => 'required|ip',
            'username' => 'string|required',
            'password' => 'string|required',
            'room_id' => 'required|numeric|exists:room,id',
        ]);

        $data->update($rawData);
        return redirect()->route('device.index')->withNotify('Data berhasil diubah');
    }

    public function destroy(string $uuid)
    {
        $data = Device::where('uuid', $uuid)->firstOrFail();
        $data->delete();
        return redirect()->route('device.index')->withNotify('Data berhasil dihapus');
    }
}
