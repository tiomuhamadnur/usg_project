<?php

namespace App\Http\Controllers\user;

use App\DataTables\KasirDataTable;
use App\Http\Controllers\Controller;
use App\Models\DetailObat;
use App\Models\Diskon;
use App\Models\LogDiskon;
use App\Models\LogObat;
use App\Models\MetodePembayaran;
use App\Models\Obat;
use App\Models\Pemeriksaan;
use App\Models\StatusPembayaran;
use App\Models\StatusPemeriksaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Milon\Barcode\DNS1D;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class KasirController extends Controller
{
    public function index(KasirDataTable $dataTable, Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date|before_or_equal:end_date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'metode_pembayaran_id' => 'nullable|exists:metode_pembayaran,id',
            'status_pembayaran_id' => 'nullable|exists:status_pembayaran,id',
        ], [
            'start_date.before_or_equal' => 'Tanggal awal harus <= tanggal akhir',
            'end_date.after_or_equal' => 'Tanggal akhir harus >= tanggal awal',
        ]);

        $start_date = $request->start_date ?? Carbon::now()->format('Y-m-d');
        $end_date = $request->end_date ?? $start_date;
        $metode_pembayaran_id = $request->metode_pembayaran_id ?? null;
        $status_pembayaran_id = $request->status_pembayaran_id ?? 1; //Status belum bayar

        $metode_pembayaran = MetodePembayaran::all();
        $status_pembayaran = StatusPembayaran::all();

        return $dataTable->with([
            'start_date' => $start_date,
            'end_date' => $end_date,
            'metode_pembayaran_id' => $metode_pembayaran_id,
            'status_pembayaran_id' => $status_pembayaran_id,
        ])->render('pages.user.kasir.index', compact([
            'start_date',
            'end_date',
            'metode_pembayaran',
            'metode_pembayaran_id',
            'status_pembayaran',
            'status_pembayaran_id',
        ]));
    }

    public function create(Request $request)
    {
        $pemeriksaan = Pemeriksaan::where('code', $request->code)
                        ->where('status_pemeriksaan_id', 3) //status Selesai pemeriksaan dokter
                        ->where('status_pembayaran_id', 1) //status Belum lunas
                        ->first();

        if(!$pemeriksaan) {
            return redirect()->back()->withNotifyerror('Data pasien tidak ditemukan!');
        }

        return redirect()->route('kasir.edit', $pemeriksaan->uuid);
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
        $pemeriksaan = Pemeriksaan::with(['layanans.layanan', 'obats.obat'])
                                ->where('uuid', $uuid)
                                ->firstOrFail();

        $usia = Carbon::parse($pemeriksaan->pasien->tanggal_lahir)->diff(Carbon::now());
        $umur = $usia->y . ' tahun, ' . $usia->m . ' bulan, ' . $usia->d . ' hari';

        // $qrcode = QrCode::format('png')->size(150)->generate($pemeriksaan->code);
        // $qrcode_base64 = base64_encode($qrcode);

        $dns1d = new DNS1D();
        $barcode = $dns1d->getBarcodePNG($pemeriksaan->code, 'C128', 4, 90);
        $qrcode_base64 = $barcode;

        $pemeriksaan->pasien->umur = $umur;
        $pemeriksaan->qr_code = $qrcode_base64;

        $metode_pembayaran = MetodePembayaran::orderBy('name', 'ASC')->get();
        $status_pemeriksaan = StatusPemeriksaan::whereIn('id', [4])->get();
        $status_pembayaran = StatusPembayaran::whereIn('id', [2])->get();

        // Hitung biaya layanan
        $biaya_layanan = $pemeriksaan->layanans->sum(function ($item) {
            return $item->layanan->harga ?? 0;
        });

        // Hitung biaya obat (harga_jual * jumlah)
        $biaya_obat = $pemeriksaan->obats->sum(function ($item) {
            return ($item->obat->harga_jual ?? 0) * ($item->jumlah ?? 0);
        });

        $total_bayar = $biaya_layanan;

        $today = Carbon::today();

        $diskon = Diskon::whereDate('tanggal_awal', '<=', $today)
                        ->whereDate('tanggal_akhir', '>=', $today)
                        ->get();

        return view('pages.user.kasir.edit', compact([
            'pemeriksaan',
            'metode_pembayaran',
            'status_pemeriksaan',
            'status_pembayaran',
            'total_bayar',
            'diskon',
        ]));
    }

    public function update(Request $request, string $uuid)
    {
        $pemeriksaan = Pemeriksaan::where('uuid', $uuid)->firstOrFail();

        $validator = Validator::make($request->all(), [
            "total_bayar" => "required|numeric|min:1",
            "metode_pembayaran_id" => "required|numeric|min:1",
            "status_pemeriksaan_id" => "required|numeric|min:1",
            "status_pembayaran_id" => "required|numeric|min:1",
            "diskon_id" => "nullable|exists:diskon,id",
            "uuid"   => "required|array",
            "uuid.*" => "required|uuid|exists:detail_obat,uuid",
            "is_confirmed.*" => "nullable|in:0,1",
        ]);

        // 🔍 Validasi stok hanya untuk obat yang dikonfirmasi
        $validator->after(function ($validator) use ($request) {
            foreach ($request->uuid as $i => $uuidObat) {
                $isConfirmed = $request->is_confirmed[$i] ?? 0;
                if ($isConfirmed) {
                    $detail = DetailObat::where('uuid', $uuidObat)->first();
                    $obat = Obat::find($detail->obat_id);
                    if ($obat->stock < $detail->jumlah) {
                        $validator->errors()->add("uuid.$i", "Stok obat <strong>{$obat->name} ({$obat->sediaan->name})</strong> tidak mencukupi. <br> <strong>Sisa Stok:</strong> {$obat->stock} {$obat->unit->code} <br> <strong>Dibutuhkan:</strong> {$detail->jumlah} {$detail->obat->unit->code}");
                    }
                }
            }
        });

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withNotifyerror($validator->errors()->first());
        }

        // ✅ Kalau validasi lolos, langsung update
        $rawData = $request->only([
            "metode_pembayaran_id", "status_pemeriksaan_id", "status_pembayaran_id"
        ]);

        $total_bayar = $request->total_bayar ?? 0;
        $total_diskon = Diskon::find($request->diskon_id)->harga ?? 0;

        $rawData["kasir_id"] = Auth::id();
        $rawData['datetime_invoice'] = now();

        $rawData['total_diskon'] = $total_diskon;
        $rawData['total_bayar'] = $total_bayar;
        $rawData['total_grand'] = $total_bayar - $total_diskon;

        $pemeriksaan->update($rawData);

        foreach ($request->uuid as $i => $uuidObat) {
            $detail_obat = DetailObat::where('uuid', $uuidObat)->first();
            $isConfirmed = $request->is_confirmed[$i] ?? 0;

            // Simpan status confirm
            $detail_obat->update([
                'is_confirmed' => $isConfirmed,
            ]);

            // 📉 Hanya kurangi stok kalau confirmed
            if ($isConfirmed) {
                LogObat::create([
                    'obat_id'        => $detail_obat->obat_id,
                    'tipe'           => '-',
                    'qty'            => $detail_obat->jumlah,
                    'pemeriksaan_id' => $pemeriksaan->id,
                ]);
            }
        }

        LogDiskon::create([
            'pemeriksaan_id' => $pemeriksaan->id,
            'diskon_id' => $request->diskon_id,
        ]);

        return redirect()
            ->route('dashboard.index')
            ->withNotify("Data pemeriksaan berhasil disimpan. <br><strong>Pasien diperbolehkan pulang</strong>.");
    }

    public function destroy(string $id)
    {
        //
    }
}
