<?php

namespace App\Http\Controllers\admin;

use App\DataTables\PasienDataTable;
use App\Http\Controllers\Controller;
use App\Models\Agama;
use App\Models\Gender;
use App\Models\GolonganDarah;
use App\Models\HubunganPasien;
use App\Models\Pasien;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
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
            "name" => "required|string",
            "gender_id" => "required|numeric",
            "nik" => "required|numeric|min_digits:16",
            "no_bpjs" => "nullable",
            "no_rm" => "nullable",
            "satu_sehat_id" => "nullable",
            "tempat_lahir" => "required|string",
            "tanggal_lahir" => "required|date",
            "no_hp" => "required|numeric",
            "email" => "required|email",
            "agama_id" => "required|numeric",
            "pendidikan_id" => "required|numeric",
            "pekerjaan_id" => "required|numeric",
            "golongan_darah_id" => "required|numeric",
            "alamat" => "required|string",
            "provinsi_id" => "required|numeric",
            "kota_id" => "required|numeric",
            "kecamatan_id" => "required|numeric",
            "kelurahan_id" => "required|numeric",
            "alergi_obat" => "nullable",
            "alergi_makanan" => "nullable",
            "hubungan_pasien_id" => "required|numeric",
            "pj_name" => "required|string",
            "pj_gender_id" => "required|numeric",
            "pj_nik" => "required|numeric|min_digits:16",
            "pj_no_hp" => "required|numeric",
            "pj_alamat" => "required|string",
            "pj_provinsi_id" => "required|numeric",
            "pj_kota_id" => "required|numeric",
            "pj_kecamatan_id" => "required|numeric",
            "pj_kelurahan_id" => "required|numeric",
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
        dd("edit " . $uuid);
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
