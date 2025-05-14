@extends('layouts.base')

@section('header')
    <title>Admin | Registrasi Pasien</title>
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
                                <div class="col-12 col-md-8">
                                    <label class="form-label required">Nama Lengkap Pasien</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        placeholder="input nama lengkap pasien" required autocomplete="off">
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label required">Jenis Kelamin</label>
                                    <select class="form-select js-select2" name="gender_id" id="gender_id" required>
                                        <option value="" selected disabled>- pilih jenis kelamin -</option>
                                        @foreach ($gender as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-3">
                                    <label class="form-label required">NIK</label>
                                    <input type="text" class="form-control" name="nik" id="nik"
                                        placeholder="input NIK KTP" required autocomplete="off">
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label required">No. BPJS</label>
                                    <input type="text" class="form-control" name="no_bpjs" placeholder="input no. bpjs"
                                        required autocomplete="off">
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label required">No. RM</label>
                                    <input type="text" class="form-control" name="no_rm"
                                        placeholder="input no. rekam medis" required autocomplete="off">
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label required">ID Satu Sehat</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="satu_sehat_id"
                                            placeholder="input ID satu sehat" required autocomplete="off">
                                        <button type="button" class="btn btn-success">
                                            <i class="fa fa-magnifying-glass"></i>
                                            Cari</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-3">
                                    <label class="form-label required">Tempat Lahir</label>
                                    <input type="text" class="form-control" name="tempat_lahir"
                                        placeholder="input tempat lahir" required autocomplete="off">
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label required">Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="tanggal_lahir"
                                        placeholder="input tanggal lahir" required autocomplete="off">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label required">Umur</label>
                                    <div class="row g-2">
                                        <div class="col-12 col-md-4">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="umur_tahun" disabled>
                                                <span class="input-group-text">Tahun</span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="umur_bulan" disabled>
                                                <span class="input-group-text">Bulan</span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="umur_hari" disabled>
                                                <span class="input-group-text">Hari</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-6">
                                    <label class="form-label required">No. HP/WA</label>
                                    <input type="text" class="form-control" name="no_hp" id="no_hp"
                                        placeholder="input no. hp/wa" required autocomplete="off">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label required">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="input email"
                                        required autocomplete="off">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-3">
                                    <label class="form-label required">Agama</label>
                                    <select class="form-select" name="agama_id" required>
                                        <option value="" selected disabled>- pilih agama -</option>
                                        @foreach ($agama as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label required">Pendidikan</label>
                                    <select class="form-select" name="pendidikan_id" required>
                                        <option value="" selected disabled>- pilih pendidikan -</option>
                                        @foreach ($pendidikan as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label required">Pekerjaan</label>
                                    <select class="form-select" name="pekerjaan_id" required>
                                        <option value="" selected disabled>- pilih pekerjaan -</option>
                                        @foreach ($pekerjaan as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label required">Golongan Darah</label>
                                    <select class="form-select" name="golongan_darah_id" required>
                                        <option value="" selected disabled>- pilih golongan darah -</option>
                                        @foreach ($golongan_darah as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-12">
                                    <label class="form-label required" autocomplete="off">Alamat Lengkap</label>
                                    <textarea class="form-control" name="alamat" id="alamat" rows="4" placeholder="input alamat lengkap" required></textarea>
                                </div>
                            </div>
                            @livewire('form-address', ['prefix' => ''], key('pasien'))
                            <div class="row mb-4">
                                <div class="col-12 col-md-6">
                                    <label class="form-label required">Alergi Obat</label>
                                    <textarea class="form-control" name="alergi_obat" placeholder="input alergi obat" rows="3"
                                        autocomplete="off"></textarea>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label required">Alergi Makanan</label>
                                    <textarea class="form-control" name="alergi_makanan" placeholder="input alergi makanan" rows="3"
                                        autocomplete="off"></textarea>
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
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-12">
                                    <label class="form-label required">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="pj_name" id="pj_name"
                                        placeholder="input nama lengkap pasien" required autocomplete="off">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-4">
                                    <label class="form-label required">Jenis Kelamin</label>
                                    <select class="form-select" name="pj_gender_id" id="pj_gender_id" required>
                                        <option value="" selected disabled>- pilih jenis kelamin -</option>
                                        @foreach ($gender as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label required">NIK</label>
                                    <input type="text" class="form-control" name="pj_nik" id="pj_nik"
                                        placeholder="input NIK KTP" required autocomplete="off">
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label required">No. HP/WA</label>
                                    <input type="text" class="form-control" name="pj_no_hp" id="pj_no_hp"
                                        placeholder="input no. hp/wa" required autocomplete="off">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label class="form-label required">Alamat sama dengan Pasien?</label>
                                <div class="space-x-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="isSame" value="0"
                                            checked>
                                        <label class="form-check-label">Tidak</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="isSame" value="1">
                                        <label class="form-check-label">Ya</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 col-md-12">
                                    <label class="form-label required">Alamat Lengkap</label>
                                    <textarea class="form-control" name="pj_alamat" id="pj_alamat" rows="4" placeholder="input alamat lengkap"
                                        required autocomplete="off"></textarea>
                                </div>
                            </div>
                            @livewire('form-address', ['prefix' => 'pj_'], key('penanggung_jawab'))
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
                console.log('copyIdentitasKePJ called, dariPasien =', dariPasien);
                if (dariPasien) {
                    const pasien_name = $('#name').val();
                    const pasien_gender_id = $('#gender_id').val();
                    const pasien_nik = $('#nik').val();
                    const pasien_no_hp = $('#no_hp').val();

                    console.log('pasien_name:', pasien_name);
                    console.log('pasien_gender_id:', pasien_gender_id);
                    console.log('pasien_nik:', pasien_nik);
                    console.log('pasien_no_hp:', pasien_no_hp);

                    $('#pj_name').val(pasien_name);
                    $('#pj_gender_id').val(pasien_gender_id).trigger('change');
                    $('#pj_nik').val(pasien_nik);
                    $('#pj_no_hp').val(pasien_no_hp);

                    console.log('SET pj_name:', $('#pj_name').val());
                    console.log('SET pj_gender_id:', $('#pj_gender_id').val());
                    console.log('SET pj_nik:', $('#pj_nik').val());
                    console.log('SET pj_no_hp:', $('#pj_no_hp').val());
                } else {
                    $('#pj_name').val('');
                    $('#pj_gender_id').val('').trigger('change');
                    $('#pj_nik').val('');
                    $('#pj_no_hp').val('');

                    console.log('RESET semua field PJ jadi kosong');
                }
            }

            // Event ketika hubungan_pasien_id berubah
            $('#hubungan_pasien_id').on('change', function() {
                const nilai = $(this).val();
                console.log('hubungan_pasien_id changed, value =', nilai);
                if (nilai == '1') {
                    copyIdentitasKePJ(true);
                } else {
                    copyIdentitasKePJ(false);
                }
            });

            // Fungsi utama copy alamat PJ berurutan
            $('input[name="isSame"]').on('change', function() {
                const nilai = $('input[name="isSame"]:checked').val();
                console.log('isSame changed, value =', nilai);

                const alamatPasien = $('#alamat').val();
                console.log('alamat pasien:', alamatPasien);

                if (nilai == '1') {
                    $('#pj_alamat').val(alamatPasien);
                    console.log('SET pj_alamat:', alamatPasien);
                } else {
                    $('#pj_alamat').val('');
                    console.log('RESET pj_alamat kosong');
                }
            });
        });
    </script>
@endsection
