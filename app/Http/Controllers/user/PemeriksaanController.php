<?php

namespace App\Http\Controllers\user;

use App\DataTables\HistoryPemeriksaanDataTable;
use App\DataTables\PemeriksaanDokterDataTable;
use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use App\Models\Room;
use App\Models\StatusPembayaran;
use App\Models\StatusPemeriksaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PemeriksaanController extends Controller
{
    public function index(PemeriksaanDokterDataTable $dataTable, Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date|before_or_equal:end_date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'dokter_id' => 'nullable',
            'room_id' => 'nullable',
            'status_pemeriksaan_id' => 'nullable',
            'status_pembayaran_id' => 'nullable',
        ], [
            'start_date.before_or_equal' => 'Tanggal awal harus <= tanggal akhir',
            'end_date.after_or_equal' => 'Tanggal akhir harus >= tanggal awal',
        ]);

        $start_date = $request->start_date ?? Carbon::now()->format('Y-m-d');
        $end_date = $request->end_date ?? $start_date;
        $dokter_id = $request->dokter_id ?? null;
        $room_id = $request->room_id ?? null;
        $status_pemeriksaan_id = $request->status_pemeriksaan_id ?? null;
        $status_pembayaran_id = $request->status_pembayaran_id ?? null;

        $dokter = Dokter::all();
        $room = Room::all();
        $status_pemeriksaan = StatusPemeriksaan::all();
        $status_pembayaran = StatusPembayaran::all();

        return $dataTable->with([
            'start_date' => $start_date,
            'end_date' => $end_date,
            'dokter_id' => $dokter_id,
            'room_id' => $room_id,
            'status_pemeriksaan_id' => $status_pemeriksaan_id,
            'status_pembayaran_id' => $status_pembayaran_id,
        ])->render('pages.user.pemeriksaan.dokter.index', compact([
            'dokter',
            'room',
            'status_pemeriksaan',
            'status_pembayaran',
            'start_date',
            'end_date',
            'dokter_id',
            'room_id',
            'status_pemeriksaan_id',
            'status_pembayaran_id',
        ]));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $uuid, HistoryPemeriksaanDataTable $dataTable)
    {
        $pemeriksaan = Pemeriksaan::where('uuid', $uuid)->firstOrFail();

        $prevURL = route('pemeriksaan-dokter.edit', $pemeriksaan->uuid);

        return $dataTable->with([
            'pasien_uuid' => $pemeriksaan->pasien->uuid,
        ])->render('pages.user.pemeriksaan.dokter.history', compact([
            'pemeriksaan',
            'prevURL',
        ]));
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
