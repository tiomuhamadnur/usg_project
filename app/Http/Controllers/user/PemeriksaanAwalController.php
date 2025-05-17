<?php

namespace App\Http\Controllers\user;

use App\DataTables\PemeriksaanAwalDataTable;
use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use App\Models\StatusPemeriksaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PemeriksaanAwalController extends Controller
{
    public function index(PemeriksaanAwalDataTable $dataTable)
    {
        return $dataTable->render('pages.user.pemeriksaan.awal.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $uuid)
    {
        //
    }

    public function edit(string $uuid)
    {
        $pemeriksaan = Pemeriksaan::where('uuid', $uuid)->firstOrFail();

        $qrcode = QrCode::format('png')->size(150)->generate($pemeriksaan->code);
        $qrcode_base64 = base64_encode($qrcode);

        $pemeriksaan->qr_code = $qrcode_base64;

        $status_pemeriksaan = StatusPemeriksaan::whereIn('id', [2])->get();

        return view('pages.user.pemeriksaan.awal.edit', compact([
            'pemeriksaan',
            'status_pemeriksaan',
        ]));
    }

    public function update(Request $request, string $uuid)
    {
        $pemeriksaan = Pemeriksaan::where('uuid', $uuid)->firstOrFail();

        $rawData = $request->validate([
            "nadi" => "required|numeric",
            "temperatur" => "required|numeric",
            "tekanan_darah_systolic" => "required|numeric",
            "tekanan_darah_diastolic" => "required|numeric",
            "napas" => "required|numeric",
            "tinggi_badan" => "required|numeric",
            "berat_badan" => "required|numeric",
            "lingkar_perut" => "required|numeric",
            "alergi_obat" => "required|string",
            "alergi_makanan" => "required|string",
            "status_pemeriksaan_id" => "required|numeric",
        ]);

        $rawData["suster_id"] = Auth::user()->id;
        $pasien = Pasien::findOrFail($pemeriksaan->pasien_id);
        $pasien->update([
            'alergi_obat' => $request->alergi_obat,
            'alergi_makanan' => $request->alergi_makanan,
        ]);

        $pemeriksaan->update($rawData);

        return redirect()->route('pemeriksaan-awal.index')->withNotify('Data pemeriksaan awal berhasil disimpan, sekarang data masuk ke Dokter ' . $pemeriksaan->dokter->name . ' di ruangan ' . $pemeriksaan->room->name);
    }

    public function destroy(string $id)
    {
        //
    }
}
