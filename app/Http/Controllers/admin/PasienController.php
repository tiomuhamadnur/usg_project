<?php

namespace App\Http\Controllers\admin;

use App\DataTables\PasienDataTable;
use App\Http\Controllers\Controller;
use App\Models\Agama;
use App\Models\Gender;
use App\Models\GolonganDarah;
use App\Models\HubunganPasien;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Kota;
use App\Models\Pasien;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\Provinsi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index(PasienDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.pasien.index');
    }

    public function create()
    {
        $gender = Gender::all();
        $agama = Agama::all();
        $pendidikan = Pendidikan::all();
        $pekerjaan = Pekerjaan::all();
        $golongan_darah = GolonganDarah::all();
        $hubungan_pasien = HubunganPasien::all();

        return view('pages.admin.pasien.create', compact([
            'gender',
            'agama',
            'pendidikan',
            'pekerjaan',
            'golongan_darah',
            'hubungan_pasien',
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            // Data Pasien
            "name" => "required|string|max:255",
            "gender_id" => "required|numeric|exists:gender,id",
            "nik" => "required|digits:16|unique:pasien,nik",
            "no_bpjs" => "nullable|string|max:20|unique:pasien,no_bpjs",
            "no_rm" => "nullable|string|max:20|unique:pasien,no_rm",
            "satu_sehat_id" => "nullable|string|max:50|unique:pasien,satu_sehat_id",
            "tempat_lahir" => "required|string|max:100",
            "tanggal_lahir" => "required|date|before:today",
            "no_hp" => [
                'required',
                'regex:/^(?:\+62|62|0)8[1-9][0-9]{6,9}$/'
            ],
            "email" => "nullable|email|max:255",

            // Info tambahan
            "agama_id" => "nullable|numeric|exists:agama,id",
            "pendidikan_id" => "nullable|numeric|exists:pendidikan,id",
            "pekerjaan_id" => "nullable|numeric|exists:pekerjaan,id",
            "golongan_darah_id" => "nullable|numeric|exists:golongan_darah,id",

            // Alamat
            "alamat" => "required|string|max:500",
            "provinsi_id" => "required|numeric|exists:provinsi,id",
            "kota_id" => "required|numeric|exists:kota,id",
            "kecamatan_id" => "required|numeric|exists:kecamatan,id",
            "kelurahan_id" => "required|numeric|exists:kelurahan,id",

            // Alergi
            "alergi_obat" => "nullable|string|max:255",
            "alergi_makanan" => "nullable|string|max:255",

            // Penanggung Jawab
            "hubungan_pasien_id" => "required|numeric|exists:hubungan_pasien,id",
            "pj_name" => "required|string|max:255",
            "pj_gender_id" => "required|numeric|exists:gender,id",
        ], [
            'nik.required' => 'NIK KTP wajib diisi',
            'nik.unique' => 'NIK tersebut sudah terdaftar',
            'nik.digits' => 'NIK harus terdiri dari 16 digit angka',
            'no_bpjs.unique' => 'No. BPJS tersebut sudah terdaftar',
            'no_rm.unique' => 'No. RM tersebut sudah terdaftar',
            'satu_sehat_id.unique' => 'ID Satu Sehat tersebut sudah terdaftar',
            'no_hp.required' => 'Nomor HP wajib diisi',
            'no_hp.regex' => 'Format nomor HP tidak valid (contoh: 0812xxxxxxx)',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini',
        ]);


        Pasien::updateOrCreate($data, $data);

        return redirect()->route('pasien.index')->withNotify('Data berhasil ditambahkan');
    }

    public function show(string $uuid)
    {
        dd("show " . $uuid);
    }

    public function edit(string $uuid)
    {
        $pasien = Pasien::where('uuid', $uuid)->firstOrFail();
        $umur = Carbon::parse($pasien->tanggal_lahir)->diff(Carbon::now());

        $gender = Gender::all();
        $agama = Agama::all();
        $pendidikan = Pendidikan::all();
        $pekerjaan = Pekerjaan::all();
        $golongan_darah = GolonganDarah::all();
        $hubungan_pasien = HubunganPasien::all();
        $provinsi = Provinsi::all();
        $kota = Kota::all();
        $kecamatan = Kecamatan::all();
        $kelurahan = Kelurahan::all();

        return view('pages.admin.pasien.edit', compact([
            'gender',
            'agama',
            'pendidikan',
            'pekerjaan',
            'golongan_darah',
            'hubungan_pasien',
            'provinsi',
            'kota',
            'kecamatan',
            'kelurahan',
            'pasien',
        ]));
    }

    public function update(Request $request, string $uuid)
    {
        $pasien = Pasien::where('uuid', $uuid)->firstOrFail();

        $data = $request->validate([
            // Data Pasien
            "name" => "required|string|max:255",
            "gender_id" => "required|numeric|exists:gender,id",
            "nik" => "required|digits:16|unique:pasien,nik," . $pasien->id,
            "no_bpjs" => "nullable|string|max:20|unique:pasien,no_bpjs," . $pasien->id,
            "no_rm" => "nullable|string|max:20|unique:pasien,no_rm," . $pasien->id,
            "satu_sehat_id" => "nullable|string|max:50|unique:pasien,satu_sehat_id," . $pasien->id,
            "tempat_lahir" => "required|string|max:100",
            "tanggal_lahir" => "required|date|before:today",
            "no_hp" => [
                'required',
                'regex:/^(?:\+62|62|0)8[1-9][0-9]{6,9}$/'
            ],
            "email" => "nullable|email|max:255",

            // Info tambahan
            "agama_id" => "nullable|numeric|exists:agama,id",
            "pendidikan_id" => "nullable|numeric|exists:pendidikan,id",
            "pekerjaan_id" => "nullable|numeric|exists:pekerjaan,id",
            "golongan_darah_id" => "nullable|numeric|exists:golongan_darah,id",

            // Alamat
            "alamat" => "required|string|max:500",
            "provinsi_id" => "required|numeric|exists:provinsi,id",
            "kota_id" => "required|numeric|exists:kota,id",
            "kecamatan_id" => "required|numeric|exists:kecamatan,id",
            "kelurahan_id" => "required|numeric|exists:kelurahan,id",

            // Alergi
            "alergi_obat" => "nullable|string|max:255",
            "alergi_makanan" => "nullable|string|max:255",

            // Penanggung Jawab
            "hubungan_pasien_id" => "required|numeric|exists:hubungan_pasien,id",
            "pj_name" => "required|string|max:255",
            "pj_gender_id" => "required|numeric|exists:gender,id",
        ], [
            'nik.required' => 'NIK KTP wajib diisi',
            'nik.unique' => 'NIK tersebut sudah terdaftar',
            'nik.digits' => 'NIK harus terdiri dari 16 digit angka',
            'no_bpjs.unique' => 'No. BPJS tersebut sudah terdaftar',
            'no_rm.unique' => 'No. RM tersebut sudah terdaftar',
            'satu_sehat_id.unique' => 'ID Satu Sehat tersebut sudah terdaftar',
            'no_hp.required' => 'Nomor HP wajib diisi',
            'no_hp.regex' => 'Format nomor HP tidak valid (contoh: 0812xxxxxxx)',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini',
        ]);

        $pasien->update($data);

        return redirect()->route('pasien.index')->withNotify('Data Pasien ' . $pasien->name . ' berhasil diubah.');
    }

    public function destroy(string $uuid)
    {
        $pasien = Pasien::where('uuid', $uuid)->firstOrFail();
        $pasien->delete();

        return redirect()->route('pasien.index')->withNotify('Data Pasien ' . $pasien->name . ' berhasil dihapus.');
    }
}
