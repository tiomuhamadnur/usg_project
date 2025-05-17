<?php

namespace App\Http\Controllers\user;

use App\DataTables\RegistrasiDataTable;
use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RegistrasiController extends Controller
{
    public function index(RegistrasiDataTable $dataTable)
    {
        return $dataTable->render('pages.user.registrasi.index');
    }

    public function create(Request $request)
    {
        $request->validate([
            'type' => 'nullable|string',
            'value' => 'nullable|string',
        ]);

        $type = $request->type;
        $value = $request->value;

        $pasien = null;
        $dokter = Dokter::all();
        $room = Room::orderBy('name', 'ASC')->get();

        if ($type && $value) {
            try {
                $pasien = Pasien::with(['gender', 'golongan_darah', 'provinsi', 'kota', 'kecamatan', 'kelurahan'])
                    ->where($type, $value)
                    ->first();

                if (!$pasien) {
                    return redirect()->back()->withNotifyerror('Pasien tidak ditemukan');
                }
            } catch (\Exception $e) {
                return redirect()->back()->withNotifyerror('Terjadi kesalahan dalam pencarian pasien');
            }
        }

        return view('pages.user.registrasi.create', compact([
            'pasien',
            'dokter',
            'room',
        ]));
    }

    public function store(Request $request)
    {
        $request->validate([
            "pasien_uuid" => "required|string",
        ]);

        $pasien = Pasien::where('uuid', $request->pasien_uuid)->firstOrFail();

        $rawData = $request->validate([
            "dokter_id" => "required|numeric",
            "room_id" => "required|numeric",
            "datetime" => "required",
            "rencana_pasien" => "required|string",
            "keluhan_pasien" => "required|string",
        ]);

        $no_urut = Pemeriksaan::generateNoUrut($request->room_id, $request->datetime);
        $rawData['no_urut'] = $no_urut;
        $rawData['pasien_id'] = $pasien->id;

        $data = Pemeriksaan::create($rawData);

        return redirect()->route('registrasi.index')->withNotify('Data pemeriksaan berhasil ditambahkan dengan code: ' . $data->code . ' No. urut: '. $no_urut);
    }

    public function show(string $uuid)
    {
        $pemeriksaan = Pemeriksaan::where('uuid', $uuid)->firstOrFail();
        $qrcode = QrCode::format('png')->size(150)->generate($pemeriksaan->code);

        $qrcode_base64 = base64_encode($qrcode);

        return view('pages.user.registrasi.print', compact([
            'pemeriksaan',
            'qrcode_base64'
        ]));
    }

    public function edit(string $uuid)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
