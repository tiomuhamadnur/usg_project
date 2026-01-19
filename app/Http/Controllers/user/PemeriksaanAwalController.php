<?php

namespace App\Http\Controllers\user;

use App\DataTables\PemeriksaanAwalDataTable;
use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use App\Models\Room;
use App\Models\StatusPembayaran;
use App\Models\StatusPemeriksaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Milon\Barcode\DNS1D;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PemeriksaanAwalController extends Controller
{
    public function __construct()
    {
        // hanya index
        $this->middleware('permission:pemeriksaan_awal.read')->only('index');

        // selain index
        $this->middleware('permission:pemeriksaan_awal.write')
            ->except('index');
    }

    public function index(PemeriksaanAwalDataTable $dataTable, Request $request)
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
        ])->render('pages.user.pemeriksaan.awal.index', compact([
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

    public function create(Request $request)
    {
        $request->validate([
            'code' => 'required|string|exists:pemeriksaan,code',
        ], [
            'code.exists' => 'Data pasien tidak ditemukan!',
        ]);

        $pemeriksaan = Pemeriksaan::where('code', $request->code)
                        ->where('status_pemeriksaan_id', 1) //status open
                        ->first();

        if(!$pemeriksaan) {
            return redirect()->back()->withNotifyerror('Data pasien tidak ditemukan!');
        }

        return redirect()->route('pemeriksaan-awal.edit', $pemeriksaan->uuid);
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

        // $qrcode = QrCode::format('png')->size(150)->generate($pemeriksaan->code);
        // $qrcode_base64 = base64_encode($qrcode);

        $dns1d = new DNS1D();
        $barcode = $dns1d->getBarcodePNG($pemeriksaan->code, 'C128', 4, 90);
        $qrcode_base64 = $barcode;

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
            "rencana_pasien"   => "required|string",
            "keluhan_pasien"   => "required|string",
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
        $rawData['datetime_pemeriksaan_awal'] = Carbon::now()->format('Y-m-d H:i:s');
        $pasien = Pasien::findOrFail($pemeriksaan->pasien_id);
        $pasien->update([
            'alergi_obat' => $request->alergi_obat,
            'alergi_makanan' => $request->alergi_makanan,
            'berat_badan' => $request->berat_badan,
            'tinggi_badan' => $request->tinggi_badan,
            'lingkar_perut' => $request->lingkar_perut,
        ]);

        $pemeriksaan->update($rawData);

        return redirect()->route('pemeriksaan-awal.index')->withNotify('Data pemeriksaan awal berhasil disimpan, sekarang data masuk ke: <br> <strong>Dokter ' . $pemeriksaan->dokter->name ?? 'N/A') . '</strong>';
    }

    public function destroy(string $id)
    {
        //
    }
}
