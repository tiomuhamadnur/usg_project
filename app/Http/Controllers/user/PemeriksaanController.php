<?php

namespace App\Http\Controllers\user;

use App\DataTables\PemeriksaanDokterDataTable;
use App\Http\Controllers\Controller;
use App\Models\Pemeriksaan;
use App\Models\StatusPemeriksaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PemeriksaanController extends Controller
{
    public function index(PemeriksaanDokterDataTable $dataTable)
    {
        return $dataTable->render('pages.user.pemeriksaan.dokter.index');
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

        $status_pemeriksaan = StatusPemeriksaan::whereIn('id', [3])->get();

        return view('pages.user.pemeriksaan.dokter.edit', compact([
            'pemeriksaan',
            'status_pemeriksaan',
        ]));
    }

    public function update(Request $request, string $uuid)
    {
        $pemeriksaan = Pemeriksaan::where('uuid', $uuid)->firstOrFail();

        $rawData = $request->validate([
            "keluhan_utama" => "required|string",
            "keluhan_tambahan" => "required|string",
            "diagnosa_utama" => "required|string",
            "diagnosa_sekunder" => "required|string",
            "hasil_pemeriksaan" => "required|string",
            "terapi_obat" => "required|string",
            "saran" => "required|string",
            "status_pemeriksaan_id" => "required|numeric",
        ]);

        $pemeriksaan->update($rawData);

        return redirect()->route('pemeriksaan-dokter.index')->withNotify('Data pemeriksaan Dokter berhasil disimpan, bisa dilanjut ke tahap pembayaran di Kasir.');
    }

    public function destroy(string $uuid)
    {
        //
    }
}
