<?php

namespace App\Http\Controllers\user;

use App\DataTables\RegistrasiDataTable;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use App\Models\Room;
use App\Models\StatusPembayaran;
use App\Models\StatusPemeriksaan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Milon\Barcode\DNS1D;
use Rawilk\Printing\Receipts\ReceiptPrinter;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Rawilk\Printing\Facades\Printing;
use Rawilk\Printing\Receipts\Enums\BarcodeType;

class RegistrasiController extends Controller
{
    public function __construct()
    {
        // hanya index
        $this->middleware('permission:registrasi.read')->only('index');

        // selain index
        $this->middleware('permission:registrasi.write')
            ->except('index');
    }

    public function index(RegistrasiDataTable $dataTable, Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date|before_or_equal:end_date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'dokter_id' => 'nullable',
            'room_id' => 'nullable',
            'status_pemeriksaan_id' => 'nullable|exists:status_pemeriksaan,id',
            'status_pembayaran_id' => 'nullable|exists:status_pembayaran,id',
            'pasien_uuid' => 'nullable'
        ], [
            'start_date.before_or_equal' => 'Tanggal awal harus <= tanggal akhir',
            'end_date.after_or_equal' => 'Tanggal akhir harus >= tanggal awal',
        ]);

        $start_date = $request->start_date ?? Carbon::today()->toDateString();
        $end_date = $request->end_date ?? $start_date;
        $pasien_uuid = $request->pasien_uuid ?? null;

        if($pasien_uuid != null)
        {
            $start_date = $request->start_date ?? null;
            $end_date = $request->end_date ?? $start_date;
        }

        $dokter_id = $request->dokter_id ?? null;
        $room_id = $request->room_id ?? null;
        $status_pemeriksaan_id = $request->status_pemeriksaan_id ?? 1; //Default hanya yang "Open"
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
            'pasien_uuid' => $pasien_uuid,
        ])->render('pages.user.registrasi.index', compact([
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
            'uuid'  => 'nullable|string',
        ]);

        $uuid  = $request->uuid;

        $pasien = null;
        $dokter = Dokter::orderBy('name', 'ASC')->get();
        $room   = Room::orderBy('name', 'ASC')->get();
        $campaign = Campaign::orderBy('name', 'ASC')->get();

        try {
            if ($uuid) {
                // cari langsung berdasarkan uuid
                $pasien = Pasien::with(['gender', 'golongan_darah', 'provinsi', 'kota', 'kecamatan', 'kelurahan'])
                    ->where('uuid', $uuid)
                    ->firstOrFail();
            }
        } catch (\Exception $e) {
            return redirect()->back()->withNotifyerror('Pasien tidak ditemukan atau terjadi kesalahan');
        }

        return view('pages.user.registrasi.create', [
            'uuid'   => $uuid,
            'pasien' => $pasien,
            'dokter' => $dokter,
            'room'   => $room,
            'campaign'   => $campaign,
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            "pasien_uuid"      => "required|string|exists:pasien,uuid",
            "campaign_id"      => "nullable|exists:campaign,id"
        ]);

        $pasien = Pasien::where('uuid', $request->pasien_uuid)->firstOrFail();

        // Ambil tanggal dari datetime input
        $tanggal = Carbon::parse($request->datetime)->toDateString();

        // Cek apakah sudah ada pemeriksaan dengan pasien sama, tanggal sama, dan status_pemeriksaan != 'closed'
        $existing = Pemeriksaan::where('pasien_id', $pasien->id)
            ->whereDate('datetime', $tanggal)
            ->whereNot('status_pemeriksaan_id', 4)
            ->first();

        if ($existing) {
            return redirect()
                ->back()
                ->withNotifyerror([
                    "Pasien sudah memiliki pemeriksaan yang belum selesai pada tanggal yang sama. <br> <strong>(No. Registrasi: {$existing->code})</strong>"
                ])
                ->withInput();
        }

        $rawData = $request->validate([
            "dokter_id"        => "required|numeric|exists:users,id",
            // "room_id"          => "required|numeric|exists:room,id",
            // "datetime"         => "required|date|after_or_equal:today",
            // "rencana_pasien"   => "nullable|string",
            // "keluhan_pasien"   => "nullable|string",
        ], [
            'pasien_uuid.required' => 'Pasien harus dipilih.',
            'datetime.required' => 'Tanggal registrasi wajib diisi.',
            'datetime.date' => 'Format tanggal registrasi tidak valid.',
            'datetime.after_or_equal' => 'Tanggal registrasi tidak diperbolehkan backdate.',
        ]);


        $no_urut = Pemeriksaan::generateNoUrut($request->dokter_id, $request->datetime);
        $rawData['no_urut'] = $no_urut;
        $rawData['pasien_id'] = $pasien->id;
        $rawData['datetime'] = Carbon::now()->format('Y-m-d H:i:s');
        $rawData['datetime_registrasi'] = Carbon::now()->format('Y-m-d H:i:s');

        $data = Pemeriksaan::create($rawData);

        $pasien->update([
            'campaign_id' => $request->campaign_id,
        ]);

        // return redirect()->route('registrasi.index')->withNotify('Data pemeriksaan berhasil ditambahkan dengan <strong>Kode Registrasi: ' . $data->code . '</strong><br><strong>No. antrean: '. $no_urut) . '</strong>';
        return redirect()
            ->route('registrasi.create')
            ->with([
                'register' => 'Data pemeriksaan berhasil ditambahkan dengan
                    <strong>No. Registrasi: ' . $data->code . '</strong><br>
                    <strong>No. antrean: '. $no_urut . '</strong><br><br>
                    Tahap selanjutnya: <strong>Pemeriksaan Awal</strong>.',
                'print_url' => route('registrasi.show', $data->uuid)
            ]);
    }

    public function show(string $uuid)
    {
        $pemeriksaan = Pemeriksaan::where('uuid', $uuid)->firstOrFail();

        $dns1d = new DNS1D();
        $registrasi_barcode = $dns1d->getBarcodePNG($pemeriksaan->code, 'C128', 3, 70);
        $registrasi_barcode_base64 = 'data:image/png;base64,' . $registrasi_barcode;

        $pasien_barcode = $dns1d->getBarcodePNG($pemeriksaan->pasien->name, 'C128', 3, 70);
        $pasien_barcode_base64 = 'data:image/png;base64,' . $pasien_barcode;

        // $pdf = Pdf::loadView('pages.user.registrasi.print', compact([
        //         'pemeriksaan',
        //         'registrasi_barcode_base64',
        //         'pasien_barcode_base64',
        //     ]));

        // $pdf->setPaper([0, 0, 165, 290], 'portrait');

        // return $pdf->stream('Registrasi_' . $pemeriksaan->code. '_' . $pemeriksaan->pasien->name . '.pdf');

        return view('pages.user.registrasi.print', compact([
            'pemeriksaan',
            'registrasi_barcode_base64',
            'pasien_barcode_base64',
        ]));
    }

    // public function show(string $uuid)
    // {
    //     // $pemeriksaan = Pemeriksaan::where('uuid', $uuid)->firstOrFail();

    //     // // --- nama pasien: ganti spasi dengan dash ---
    //     // $namaPasien = $pemeriksaan->pasien->name ?? 'UNKNOWN';
    //     // $namaPasien = str_replace(' ', '-', $namaPasien);

    //     // // --- kode registrasi: aman langsung dipakai ---
    //     // $kodeRegistrasi = $pemeriksaan->code ?? 'UNKNOWN';

    //     // // ESC/POS Receipt
    //     // $printer = new ReceiptPrinter();

    //     // $printer->centerAlign()
    //     //     ->text("=== KLINIK USG AJA ===\n")
    //     //     ->text("by dr. Naya\n")
    //     //     ->text("Jl. Taman Cimanggu Tengah No.11\n")
    //     //     ->text("Telp: 0895-0894-7548\n")
    //     //     ->line()
    //     //     ->leftAlign()
    //     //     ->twoColumnText("Tanggal", $pemeriksaan->datetime_registrasi)
    //     //     ->twoColumnText("Dokter", $pemeriksaan->dokter->name ?? 'N/A')
    //     //     ->line()
    //     //     ->centerAlign()
    //     //     ->text("Pasien: {$namaPasien}\n")
    //     //     ->barcode('{B' . $namaPasien, 73)   // Code128
    //     //     ->line()
    //     //     ->text("No. Antrean\n")
    //     //     ->setTextSize(2, 2)
    //     //     ->text("{$pemeriksaan->no_urut}\n")
    //     //     ->setTextSize(1, 1)
    //     //     ->line()
    //     //     ->text("No. Registrasi\n")
    //     //     ->barcode('{B' . $kodeRegistrasi, 73)   // Code128
    //     //     ->line()
    //     //     ->text("*** Terima Kasih ***\n")
    //     //     ->text("Simpan struk ini untuk keperluan administrasi\n")
    //     //     ->feed(3)
    //     //     ->cut();

    //     $path = public_path('storage/test.pdf');

    //     // Kirim ke printer default
    //     Printing::newPrintTask()
    //         ->printer((int) config('printing.default_printer_id'))
    //         ->file($path)
    //         ->send();

    //     return redirect()->route('dashboard.index')->withNotify('Data registrasi berhasil dicetak!');
    // }

    public function edit(string $uuid)
    {
        $pemeriksaan = Pemeriksaan::where('uuid', $uuid)->firstOrFail();

        if($pemeriksaan->status_pemeriksaan_id != 1)
        {
            return redirect()->route('registrasi.index')->withNotifyerror('Data pemeriksaan sudah berstatus: <br> <strong>"' . $pemeriksaan->status_pemeriksaan->name . '"</strong> <br> Data tidak bisa diubah.');
        }

        $dokter = Dokter::orderBy('name', 'ASC')->get();
        $room = Room::orderBy('name', 'ASC')->get();
        $campaign = Campaign::orderBy('name', 'ASC')->get();

        return view('pages.user.registrasi.edit', compact([
            'pemeriksaan',
            'dokter',
            'room',
            'campaign',
        ]));
    }

    public function update(Request $request, string $uuid)
    {
        $pemeriksaan = Pemeriksaan::where('uuid', $uuid)->firstOrFail();

        $rawData = $request->validate([
            "dokter_id"        => "required|numeric|exists:users,id",
            // "room_id"          => "required|numeric|exists:room,id",
            "datetime_registrasi"         => "required|date|after_or_equal:now",
            // "rencana_pasien"   => "nullable|string",
            // "keluhan_pasien"   => "nullable|string",
        ], [
            'datetime.required' => 'Tanggal registrasi wajib diisi.',
            'datetime.date' => 'Format tanggal registrasi tidak valid.',
            'datetime_registrasi.after_or_equal' => 'Tanggal registrasi tidak diperbolehkan backdate.',
        ]);

        $request->validate([
            'campaign_id' => 'nullable|exists:campaign,id'
        ]);

        $pemeriksaan->update($rawData);
        $pasien = Pasien::findOrFail($pemeriksaan->pasien_id);

        $pasien->update([
            'campaign_id' => $request->campaign_id,
        ]);

        return redirect()->route('registrasi.index')->withNotify('Data pemeriksaan berhasil diubah dengan <br><strong>No. Registrasi: ' . $pemeriksaan->code . '</strong><br> <strong>No. urut: '. $pemeriksaan->no_urut) . '</strong>';
    }

    public function destroy(string $uuid)
    {
        $pemeriksaan = Pemeriksaan::where('uuid', $uuid)->firstOrFail();

        $pemeriksaan->forceDelete();

        return redirect()->route('registrasi.index')->withNotify('Data berhasil dihapus');
    }
}
