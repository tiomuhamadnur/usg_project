@extends('layouts.base')

@section('header')
    <title>Tambah Pasien Baru</title>
@endsection

@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Table -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <div class="d-flex justify-content-between align-items-center w-100 flex-nowrap">
                    <h3 class="fs-3 fw-semibold my-2 mb-0">
                        Tambah Pasien Baru
                    </h3>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Form Grid with Labels -->
                        <form action="{{ route('pasien.store') }}" id="formAdd" method="POST">
                            @method('POST')
                            @csrf
                            <div class="row mb-4">
                                <div class="col-12 col-md-6">
                                    <label class="form-label required">Nama Lengkap Pasien</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{{ old('name') }}" placeholder="input nama lengkap pasien" required
                                        autocomplete="off">
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label required">Jenis Kelamin</label>
                                    <select class="form-select js-select2" name="gender_id" id="gender_id" required>
                                        <option value="" selected disabled>- pilih jenis kelamin -</option>
                                        @foreach ($gender as $item)
                                            <option value="{{ $item->id }}" @selected($item->id == old('gender_id'))>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label required">NIK</label>
                                    <input type="text" class="form-control" name="nik" id="nik"
                                        value="{{ old('nik') }}" placeholder="input NIK (16 digit)" required
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-4">
                                    <label class="form-label optional">No. BPJS</label>
                                    <input type="text" class="form-control" name="no_bpjs" value="{{ old('no_bpjs') }}"
                                        placeholder="input no. bpjs" autocomplete="off">
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label optional">No. RM</label>
                                    <input type="text" class="form-control" name="no_rm" value="{{ old('no_rm') }}"
                                        placeholder="input no. rekam medis" autocomplete="off">
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label optional">ID Satu Sehat</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="satu_sehat_id"
                                            value="{{ old('satu_sehat_id') }}" placeholder="input ID satu sehat"
                                            autocomplete="off">
                                        {{-- <button type="button" class="btn btn-success">
                                            <i class="fa fa-magnifying-glass"></i>
                                            Cari</button> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-3">
                                    <label class="form-label required">Tempat Lahir</label>
                                    <input type="text" class="form-control" name="tempat_lahir"
                                        value="{{ old('tempat_lahir') }}" placeholder="input tempat lahir" required
                                        autocomplete="off">
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label required">Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir"
                                        value="{{ old('tanggal_lahir') }}" placeholder="input tanggal lahir" required
                                        autocomplete="off">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label auto">Umur</label>
                                    <div class="row g-2">
                                        <div class="col-12 col-md-4">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="umur_tahun" value="0"
                                                    disabled>
                                                <span class="input-group-text">Tahun</span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="umur_bulan" value="0"
                                                    disabled>
                                                <span class="input-group-text">Bulan</span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="umur_hari" value="0"
                                                    disabled>
                                                <span class="input-group-text">Hari</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-6">
                                    <label class="form-label required">No. HP/WA</label>
                                    <input type="tel" class="form-control" name="no_hp" id="no_hp"
                                        value="{{ old('no_hp') }}" placeholder="contoh: 08xxxxxxxxxx"
                                        pattern="^(\+62|62|0)8[1-9][0-9]{6,9}$" required autocomplete="off">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label optional">Email</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        placeholder="input email" value="{{ old('email') }}" autocomplete="off">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-3">
                                    <label class="form-label optional">Agama</label>
                                    <select class="form-select" name="agama_id">
                                        <option value="" selected disabled>- pilih agama -</option>
                                        @foreach ($agama as $item)
                                            <option value="{{ $item->id }}" @selected($item->id == old('agama_id'))>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label optional">Pendidikan</label>
                                    <select class="form-select" name="pendidikan_id">
                                        <option value="" selected disabled>- pilih pendidikan -</option>
                                        @foreach ($pendidikan as $item)
                                            <option value="{{ $item->id }}" @selected($item->id == old('pendidikan_id'))>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label optional">Pekerjaan</label>
                                    <select class="form-select" name="pekerjaan_id">
                                        <option value="" selected disabled>- pilih pekerjaan -</option>
                                        @foreach ($pekerjaan as $item)
                                            <option value="{{ $item->id }}" @selected($item->id == old('pekerjaan_id'))>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label optional">Golongan Darah</label>
                                    <select class="form-select" name="golongan_darah_id">
                                        <option value="" selected disabled>- pilih golongan darah -</option>
                                        @foreach ($golongan_darah as $item)
                                            <option value="{{ $item->id }}" @selected($item->id == old('golongan_darah_id'))>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-12">
                                    <label class="form-label required" autocomplete="off">Alamat Lengkap</label>
                                    <textarea class="form-control" name="alamat" id="alamat" rows="4" placeholder="input alamat lengkap"
                                        required>{{ old('alamat') }}</textarea>
                                </div>
                            </div>
                            @livewire('form-address', ['prefix' => ''], key('pasien'))
                            <div class="row mb-4">
                                <div class="col-12 col-md-6">
                                    <label class="form-label optional">Alergi Obat</label>
                                    <textarea class="form-control" name="alergi_obat" placeholder="input alergi obat" rows="3"
                                        autocomplete="off">{{ old('alergi_obat') }}</textarea>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label optional">Alergi Makanan</label>
                                    <textarea class="form-control" name="alergi_makanan" placeholder="input alergi makanan" rows="3"
                                        autocomplete="off">{{ old('alergi_makanan') }}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <hr class="border border-3 border-dark my-4">
                            </div>
                            <h3 class="fs-3 fw-semibold mb-4">
                                Penanggung Jawab dari Pasien
                            </h3>
                            <div class="row mb-4">
                                <div class="col-12 col-md-12">
                                    <label class="form-label required">Hubungan dengan Pasien</label>
                                    <select class="form-select" name="hubungan_pasien_id" id="hubungan_pasien_id"
                                        required>
                                        <option value="" selected disabled>- pilih hubungan dengan pasien -</option>
                                        @foreach ($hubungan_pasien as $item)
                                            <option value="{{ $item->id }}" @selected($item->id == old('hubungan_pasien_id'))>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-8">
                                    <label class="form-label required">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="pj_name" id="pj_name"
                                        value="{{ old('pj_name') }}" placeholder="input nama lengkap pasien" required
                                        autocomplete="off">
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label required">Jenis Kelamin</label>
                                    <select class="form-select" name="pj_gender_id" id="pj_gender_id" required>
                                        <option value="" selected disabled>- pilih jenis kelamin -</option>
                                        @foreach ($gender as $item)
                                            <option value="{{ $item->id }}" @selected($item->id == old('pj_gender_id'))>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                        <!-- END Form Grid with Labels -->
                    </div>
                </div>
            </div>
            <div class="block-header block-header-default d-flex justify-content-end">
                <button type="submit" form="formAdd" class="btn btn-lg btn-primary my-3">
                    <i class="fa fa-floppy-disk"></i>
                    Simpan
                </button>
            </div>
        </div>
        <!-- END Table -->
    </div>
    <!-- END Page Content -->
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            // Copy data identitas dari Pasien ke PJ
            function copyIdentitasKePJ(dariPasien) {
                if (dariPasien) {
                    const pasien_name = $('#name').val();
                    const pasien_gender_id = $('#gender_id').val();

                    $('#pj_name').val(pasien_name);
                    $('#pj_gender_id').val(pasien_gender_id).trigger('change');
                } else {
                    $('#pj_name').val('');
                    $('#pj_gender_id').val('').trigger('change');
                }
            }

            // Event ketika hubungan_pasien_id berubah
            $('#hubungan_pasien_id').on('change', function() {
                const nilai = $(this).val();
                if (nilai == '1') {
                    copyIdentitasKePJ(true);
                } else {
                    copyIdentitasKePJ(false);
                }
            });

            // Event ketika tanggal_lahir berubah
            $('#tanggal_lahir').on('change', function() {
                const tanggalLahir = new Date($(this).val());
                const hariIni = new Date();

                if (isNaN(tanggalLahir)) {
                    $('#umur_tahun').val('');
                    $('#umur_bulan').val('');
                    $('#umur_hari').val('');
                    return;
                }

                let tahun = hariIni.getFullYear() - tanggalLahir.getFullYear();
                let bulan = hariIni.getMonth() - tanggalLahir.getMonth();
                let hari = hariIni.getDate() - tanggalLahir.getDate();

                if (hari < 0) {
                    bulan -= 1;
                    const prevMonth = new Date(hariIni.getFullYear(), hariIni.getMonth(), 0);
                    hari += prevMonth.getDate();
                }

                if (bulan < 0) {
                    tahun -= 1;
                    bulan += 12;
                }

                $('#umur_tahun').val(tahun);
                $('#umur_bulan').val(bulan);
                $('#umur_hari').val(hari);
            });
        });
    </script>
@endsection
