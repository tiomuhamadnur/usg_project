<?php

namespace App\Http\Controllers\user;

use App\DataTables\KasirDataTable;
use App\Http\Controllers\Controller;
use App\Models\MetodePembayaran;
use App\Models\Pemeriksaan;
use App\Models\StatusPembayaran;
use App\Models\StatusPemeriksaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class KasirController extends Controller
{
    public function index(KasirDataTable $dataTable)
    {
        return $dataTable->render('pages.user.kasir.index');
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

        $usia = Carbon::parse($pemeriksaan->pasien->tanggal_lahir)->diff(Carbon::now());
        $umur = $usia->y . ' tahun, ' . $usia->m . ' bulan, ' . $usia->d . ' hari';

        $qrcode = QrCode::format('png')->size(150)->generate($pemeriksaan->code);
        $qrcode_base64 = base64_encode($qrcode);

        $pemeriksaan->pasien->umur = $umur;
        $pemeriksaan->qr_code = $qrcode_base64;

        $metode_pembayaran = MetodePembayaran::orderBy('name', 'ASC')->get();
        $status_pemeriksaan = StatusPemeriksaan::whereIn('id', [4])->get();
        $status_pembayaran = StatusPembayaran::whereIn('id', [2])->get();

        return view('pages.user.kasir.edit', compact([
            'pemeriksaan',
            'metode_pembayaran',
            'status_pemeriksaan',
            'status_pembayaran',
        ]));
    }

    public function update(Request $request, string $uuid)
    {
        $pemeriksaan = Pemeriksaan::where('uuid', $uuid)->firstOrFail();

        $rawData = $request->validate([
            "total_bayar" => "required|numeric|min:1",
            "metode_pembayaran_id" => "required|numeric|min:1",
            "status_pemeriksaan_id" => "required|numeric|min:1",
            "status_pembayaran_id" => "required|numeric|min:1",
        ]);

        $rawData["kasir_id"] = Auth::user()->id;

        $pemeriksaan->update($rawData);

        return redirect()->route('kasir.index')->withNotify('Data pemeriksaan dan pembayaran berhasil disimpan, pasien diperbolehkan pulang.');
    }

    public function destroy(string $id)
    {
        //
    }
}
