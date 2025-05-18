@extends('layouts.base')

@section('header')
    <title>Edit Registrasi Pasien</title>
@endsection

@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Table -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <div class="d-flex justify-content-between align-items-center w-100 flex-nowrap">
                    <h3 class="fs-3 fw-semibold my-2 mb-0">
                        Edit Registrasi Pasien
                    </h3>
                    <a href="{{ route('registrasi.index') }}" class="btn btn-danger">
                        <i class="fa fa-times me-1"></i> Batal
                    </a>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Form Grid with Labels -->
                        <form action="#">
                            <!-- Form Horizontal - Default Style -->
                            <div class="row col-12">
                                <div class="col-6">
                                    <form class="mb-5" action="#" method="POST">
                                        @method('POST')
                                        @csrf
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label">Member ID</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" disabled
                                                    value="{{ $pemeriksaan->pasien->member_code ?? '-' }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label">Nama Pasien</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" disabled
                                                    value="{{ $pemeriksaan->pasien->name ?? '-' }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label">Jenis Kelamin</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" disabled
                                                    value="{{ $pemeriksaan->pasien->gender->name ?? '-' }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label">NIK KTP</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" disabled
                                                    value="{{ $pemeriksaan->pasien->nik ?? '-' }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label">No. BPJS</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" disabled
                                                    value="{{ $pemeriksaan->pasien->no_bpjs ?? '-' }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label">Tempat Lahir</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" disabled
                                                    value="{{ $pemeriksaan->pasien->tempat_lahir ?? '-' }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label">Tanggal Lahir</label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control" disabled
                                                    value="{{ $pemeriksaan->pasien->tanggal_lahir ?? '-' }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label">Golongan Darah</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" disabled
                                                    value="{{ $pemeriksaan->pasien->golongan_darah->name ?? '-' }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label">No. HP/WA</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" disabled
                                                    value="{{ $pemeriksaan->pasien->no_hp ?? '-' }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label">Alamat</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control" rows="3" disabled>{{ $pemeriksaan->pasien->alamat ?? '-' }}, {{ $pemeriksaan->pasien->kelurahan->name ?? '-' }}, {{ $pemeriksaan->pasien->kecamatan->name ?? '-' }}, {{ $pemeriksaan->pasien->kota->name ?? '-' }}, {{ $pemeriksaan->pasien->provinsi->name ?? '-' }}</textarea>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-6">
                                    <form class="mb-5" id="formRegistrasi"
                                        action="{{ route('registrasi.update', $pemeriksaan->uuid) }}" method="POST">
                                        @method('PUT')
                                        @csrf
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label required">Dokter</label>
                                            <div class="col-sm-8">
                                                <select class="form-select" name="dokter_id" id="dokter_id" required>
                                                    <option value="" disabled selected>- pilih dokter -</option>
                                                    @foreach ($dokter as $item)
                                                        <option value="{{ $item->id }}" @selected(old('dokter_id', $pemeriksaan->dokter_id) == $item->id)>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label required">Ruangan</label>
                                            <div class="col-sm-8">
                                                <select class="form-select" name="room_id" id="room_id" required>
                                                    <option value="" disabled selected>- pilih ruangan -</option>
                                                    @foreach ($room as $item)
                                                        <option value="{{ $item->id }}" @selected(old('room_id', $pemeriksaan->room_id) == $item->id)>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label required">Tanggal & Jam</label>
                                            <div class="col-sm-8">
                                                <input type="datetime-local" name="datetime" id="datetime"
                                                    class="form-control" required
                                                    value="{{ old('datetime', $pemeriksaan->datetime ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label required">Rencana Pasien</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control" name="rencana_pasien" id="rencana_pasien" rows="3"
                                                    placeholder="input rencana tindakan">{{ old('rencana_pasien', $pemeriksaan->rencana_pasien ?? '') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label required">Keluhan Pasien</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control" name="keluhan_pasien" id="keluhan_pasien" rows="3"
                                                    placeholder="input keluhan">{{ old('keluhan_pasien', $pemeriksaan->keluhan_pasien ?? '') }}</textarea>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- END Form Horizontal - Default Style -->
                        </form>
                        <!-- END Form Grid with Labels -->
                    </div>
                </div>
            </div>
            <div class="block-header block-header-default d-flex justify-content-end">
                <button type="submit" form="formRegistrasi" class="btn btn-lg btn-primary my-3">
                    <i class="fa fa-floppy-disk"></i>
                    Simpan Perubahan
                </button>
            </div>
        </div>
        <!-- END Table -->
    </div>
    <!-- END Page Content -->
@endsection

@section('javascript')
@endsection
