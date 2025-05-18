<?php

namespace App\Http\Controllers\user;

use App\DataTables\RegistrasiDataTable;
use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use App\Models\Room;
use App\Models\StatusPembayaran;
use App\Models\StatusPemeriksaan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RegistrasiController extends Controller
{
    public function index(RegistrasiDataTable $dataTable, Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date|before_or_equal:end_date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'dokter_id' => 'nullable',
            'room_id' => 'nullable',
            'status_pemeriksaan_id' => 'nullable',
            'status_pembayaran_id' => 'nullable',
            'pasien_uuid' => 'nullable'
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
        $pasien_uuid = $request->pasien_uuid ?? null;

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
            'type' => 'nullable|string',
            'value' => 'nullable|string',
        ]);

        $type = $request->type;
        $value = $request->value;

        $pasien = null;
        $dokter = Dokter::orderBy('name', 'ASC')->get();
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

        return view('pages.user.registrasi.create', [
            'type' => $type ?? null,
            'value' => $value ?? null,
            'pasien' => $pasien,
            'dokter' => $dokter,
            'room' => $room,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "pasien_uuid"      => "required|string|exists:pasien,uuid",
        ]);

        $pasien = Pasien::where('uuid', $request->pasien_uuid)->firstOrFail();

        // Ambil tanggal dari datetime input
        $tanggal = Carbon::parse($request->datetime)->toDateString();

        // Cek apakah sudah ada pemeriksaan dengan pasien sama, tanggal sama, dan status_pemeriksaan != 'closed'
        $existing = Pemeriksaan::where('pasien_id', $pasien->id)
            ->whereDate('datetime', $tanggal)
            ->where('status_pemeriksaan_id', '!=', 4)
            ->first();

        if ($existing) {
            return redirect()
                ->back()
                ->withNotifyerror([
                    "Pasien sudah memiliki pemeriksaan yang belum selesai pada tanggal yang sama. (Kode registrasi: {$existing->code})"
                ])
                ->withInput();;
        }

        $rawData = $request->validate([
            "dokter_id"        => "required|numeric|exists:users,id",
            "room_id"          => "required|numeric|exists:room,id",
            "datetime"         => "required|date|after_or_equal:now",
            "rencana_pasien"   => "required|string",
            "keluhan_pasien"   => "required|string",
        ], [
            'pasien_uuid.required' => 'Pasien harus dipilih.',
            'datetime.required' => 'Tanggal registrasi wajib diisi.',
            'datetime.date' => 'Format tanggal registrasi tidak valid.',
            'datetime.after_or_equal' => 'Tanggal registrasi tidak diperbolehkan backdate.',
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
        $pemeriksaan = Pemeriksaan::where('uuid', $uuid)->firstOrFail();

        if($pemeriksaan->status_pemeriksaan_id != 1)
        {
            return redirect()->route('registrasi.index')->withNotifyerror('Data pemeriksaan sudah berstatus "' . $pemeriksaan->status_pemeriksaan->name . '", tidak bisa diubah.');
        }

        $dokter = Dokter::orderBy('name', 'ASC')->get();
        $room = Room::orderBy('name', 'ASC')->get();

        return view('pages.user.registrasi.edit', compact([
            'pemeriksaan',
            'dokter',
            'room',
        ]));
    }

    public function update(Request $request, string $uuid)
    {
        $pemeriksaan = Pemeriksaan::where('uuid', $uuid)->firstOrFail();

        $rawData = $request->validate([
            "dokter_id"        => "required|numeric|exists:users,id",
            "room_id"          => "required|numeric|exists:room,id",
            "datetime"         => "required|date|after_or_equal:now",
            "rencana_pasien"   => "required|string",
            "keluhan_pasien"   => "required|string",
        ], [
            'datetime.required' => 'Tanggal registrasi wajib diisi.',
            'datetime.date' => 'Format tanggal registrasi tidak valid.',
            'datetime.after_or_equal' => 'Tanggal registrasi tidak diperbolehkan backdate.',
        ]);

        $pemeriksaan->update($rawData);

        return redirect()->route('registrasi.index')->withNotify('Data pemeriksaan berhasil diubah dengan code: ' . $pemeriksaan->code . ' No. urut: '. $pemeriksaan->no_urut);
    }

    public function destroy(string $uuid)
    {
        $pemeriksaan = Pemeriksaan::where('uuid', $uuid)->firstOrFail();

        $pemeriksaan->delete();

        return redirect()->route('registrasi.index')->withNotify('Data berhasil dihapus');
    }
}
