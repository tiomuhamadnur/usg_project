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
                        Registrasi Pasien
                    </h3>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Form Grid with Labels -->
                        <form action="#">
                            <div class="row mb-4">
                                <form action="{{ route('registrasi.create') }}" method="GET">
                                    @csrf
                                    @method('GET')
                                    <div class="col-12 col-md-5">
                                        <label class="form-label required">Cari Berdasarkan?</label>
                                        <select class="form-select" name="type" id="type" required>
                                            <option value="" selected disabled>- pilih pencarian -</option>
                                            <option value="nik">NIK KTP</option>
                                            <option value="no_bpjs">No. BPJS</option>
                                            <option value="member_code">Member ID</option>
                                            <option value="no_rm">No. Rekam Medis</option>
                                            <option value="satu_sehat_id">ID Satu Sehat</option>
                                            <option value="no_hp">No. HP/WA</option>
                                            <option value="email">Email</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <label class="form-label required">Value</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="value" id="value"
                                                placeholder="input value" required autocomplete="off">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fa fa-magnifying-glass"></i>
                                                Cari</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- Form Horizontal - Default Style -->
                            @if ($pasien != null)
                                <div class="row">
                                    <hr class="border border-3 border-dark my-4">
                                </div>
                                <div class="row col-12">
                                    <div class="col-6">
                                        <form class="mb-5" action="#" method="POST">
                                            @method('POST')
                                            @csrf
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label">Member ID</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" disabled
                                                        value="{{ $pasien->member_code }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label">Nama Pasien</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" disabled
                                                        value="{{ $pasien->name }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label">Jenis Kelamin</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" disabled
                                                        value="{{ $pasien->gender->name ?? '-' }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label">NIK KTP</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" disabled
                                                        value="{{ $pasien->nik }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label">No. BPJS</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" disabled
                                                        value="{{ $pasien->no_bpjs }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label">Tempat Lahir</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" disabled
                                                        value="{{ $pasien->tempat_lahir }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label">Tanggal Lahir</label>
                                                <div class="col-sm-8">
                                                    <input type="date" class="form-control" disabled
                                                        value="{{ $pasien->tanggal_lahir }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label">Golongan Darah</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" disabled
                                                        value="{{ $pasien->golongan_darah->name ?? '-' }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label">No. HP/WA</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" disabled
                                                        value="{{ $pasien->no_hp }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label">Alamat</label>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control" rows="3" disabled>{{ $pasien->alamat }}, {{ $pasien->kelurahan->name ?? '-' }}, {{ $pasien->kecamatan->name ?? '-' }}, {{ $pasien->kota->name ?? '-' }}, {{ $pasien->provinsi->name ?? '-' }}</textarea>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-6">
                                        <form class="mb-5" id="formRegistrasi"
                                            action="{{ route('registrasi.store') }}" method="POST">
                                            @method('POST')
                                            @csrf
                                            <input type="hidden" name="pasien_uuid" value="{{ $pasien->uuid }}">
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label required">Dokter</label>
                                                <div class="col-sm-8">
                                                    <select class="form-select" name="dokter_id" id="dokter_id" required>
                                                        <option value="" disabled selected>- pilih dokter -</option>
                                                        @foreach ($dokter as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}
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
                                                            <option value="{{ $item->id }}">{{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label required">Tanggal & Jam</label>
                                                <div class="col-sm-8">
                                                    <input type="datetime-local" name="datetime" id="datetime"
                                                        class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label required">Rencana Pasien</label>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control" name="rencana_pasien" id="rencana_pasien" rows="3"
                                                        placeholder="input rencana tindakan"></textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label required">Keluhan Pasien</label>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control" name="keluhan_pasien" id="keluhan_pasien" rows="3"
                                                        placeholder="input keluhan"></textarea>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
                            <!-- END Form Horizontal - Default Style -->
                        </form>
                        <!-- END Form Grid with Labels -->
                    </div>
                </div>
            </div>
            <div class="block-header block-header-default d-flex justify-content-end">
                @if ($pasien != null)
                    <button type="submit" form="formRegistrasi" class="btn btn-lg btn-primary my-3">
                        <i class="fa fa-floppy-disk"></i>
                        Simpan
                    </button>
                @endif
            </div>
        </div>
        <!-- END Table -->
    </div>
    <!-- END Page Content -->
@endsection

@section('javascript')
@endsection
