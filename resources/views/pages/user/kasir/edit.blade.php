@extends('layouts.base')

@section('header')
    <title>Admin | Kasir</title>
@endsection

@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Table -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <div class="d-flex justify-content-between align-items-center w-100 flex-nowrap">
                    <h3 class="fs-3 fw-semibold my-2 mb-0">
                        Kasir
                    </h3>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="row col-12">
                    <div class="col-6">
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label">Kode Registrasi</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="text" class="form-control" disabled value="{{ $pemeriksaan->code }}">
                                    <button type="submit" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#QRCodeModal">
                                        <i class="fa fa-qrcode"></i>
                                        QR Code
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label">Nama Pasien</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" disabled
                                    value="{{ $pemeriksaan->pasien->name }}">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" disabled
                                    value="{{ $pemeriksaan->pasien->gender->name }}">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label">Rencana Pasien</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" disabled rows="2">{{ $pemeriksaan->rencana_pasien }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label">Keluhan Pasien</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" disabled rows="2">{{ $pemeriksaan->keluhan_pasien }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label">Tanggal Lahir</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" disabled
                                    value="{{ $pemeriksaan->pasien->tanggal_lahir }}">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label">Umur</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" disabled
                                    value="{{ $pemeriksaan->pasien->umur->tahun }} tahun, {{ $pemeriksaan->pasien->umur->bulan }} bulan, {{ $pemeriksaan->pasien->umur->hari }} hari">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label">Dokter</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" disabled
                                    value="{{ $pemeriksaan->dokter->name }}">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label">Ruangan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" disabled value="{{ $pemeriksaan->room->name }}">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label">Alamat</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" disabled rows="2">{{ $pemeriksaan->pasien->alamat }}, {{ $pemeriksaan->pasien->kelurahan->name }}, {{ $pemeriksaan->pasien->kecamatan->name }}, {{ $pemeriksaan->pasien->kota->name }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row border border-2 mt-3">
                    <div class="col-lg-12">
                        <!-- Block Tabs Animated Slide Up -->
                        <div class="block block-rounded">
                            <form action="{{ route('kasir.update', $pemeriksaan->uuid) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <ul class="nav nav-tabs nav-tabs-block" role="tablist">
                                    <li class="nav-item">
                                        <button class="nav-link active" id="btabs-animated-slideup-home-tab"
                                            data-bs-toggle="tab" data-bs-target="#btabs-animated-slideup-home"
                                            role="tab" aria-controls="btabs-animated-slideup-home" aria-selected="true">
                                            <i class="fa fa-money-check-dollar"></i>
                                            Pembayaran
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" id="btabs-animated-slideup-status-tab" data-bs-toggle="tab"
                                            data-bs-target="#btabs-animated-slideup-status" role="tab"
                                            aria-controls="btabs-animated-slideup-status" aria-selected="false">
                                            <i class="fa fa-circle-check"></i>
                                            Status
                                        </button>
                                    </li>
                                </ul>
                                <div class="block-content tab-content overflow-hidden">
                                    <div class="tab-pane fade fade-up show active" id="btabs-animated-slideup-home"
                                        role="tabpanel" aria-labelledby="btabs-animated-slideup-home-tab" tabindex="0">
                                        <h4 class="fw-bolder">Pembayaran Pasien</h4>
                                        <div class="row col-12">
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label required">Total Bayar (Rp.)</label>
                                                <div class="col-sm-7">
                                                    <input type="number" min="1" class="form-control"
                                                        name="total_bayar" autocomplete="off" required
                                                        placeholder="input total bayar"
                                                        value="{{ $pemeriksaan->total_bayar }}">
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label required">Metode Pembayaran</label>
                                                <div class="col-sm-7">
                                                    <select class="form-select" name="metode_pembayaran_id" required>
                                                        <option value="" disabled selected>- pilih metode pembayaran
                                                            -</option>
                                                        @foreach ($metode_pembayaran as $item)
                                                            <option value="{{ $item->id }}"
                                                                @selected($item->id == $pemeriksaan->metode_pembayaran_id)>
                                                                {{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end mt-3">
                                            <button type="button" class="btn btn-lg btn-success" id="nextToStatus">
                                                <i class="fa fa-arrow-right"></i>
                                                Next
                                            </button>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade fade-up" id="btabs-animated-slideup-status" role="tabpanel"
                                        aria-labelledby="btabs-animated-slideup-status-tab" tabindex="0">
                                        <h4 class="fw-bolder">Status Pasien</h4>
                                        <div class="row col-12">
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label required">Status Pemeriksaan</label>
                                                <div class="col-sm-7">
                                                    <select class="form-select" name="status_pemeriksaan_id" required>
                                                        <option value="" disabled selected>- pilih status pemeriksaan
                                                            -</option>
                                                        @foreach ($status_pemeriksaan as $item)
                                                            <option value="{{ $item->id }}">
                                                                {{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label required">Status Pembayaran</label>
                                                <div class="col-sm-7">
                                                    <select class="form-select" name="status_pembayaran_id" required>
                                                        <option value="" disabled selected>- pilih status pembayaran
                                                            -</option>
                                                        @foreach ($status_pembayaran as $item)
                                                            <option value="{{ $item->id }}">
                                                                {{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end mt-3">
                                            <button type="button" class="btn btn-lg btn-secondary me-2"
                                                id="prevToPengukuran">
                                                <i class="fa fa-arrow-left"></i>
                                                Back
                                            </button>
                                            <button type="submit" class="btn btn-lg btn-primary">
                                                <i class="fa fa-floppy-disk"></i>
                                                Simpan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- END Block Tabs Animated Slide Up -->
                    </div>
                </div>
            </div>
        </div>
        <!-- END Table -->
    </div>
    <!-- END Page Content -->
@endsection

@section('modals')
    <!-- QR Code Modal -->
    <div class="modal fade" id="QRCodeModal" tabindex="-1" role="dialog" aria-labelledby="modal-block-popin"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-popin" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Kode Registrasi</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="text-center">
                            <img class="img img-thumbnail" style="height: 60%; width: 60%;" id="qrcode_img"
                                src="data:image/png;base64,{{ $pemeriksaan->qr_code }}" alt="QR-code">
                            <h1 class="mt-2 fw-bolder">{{ $pemeriksaan->code }}</h1>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-end bg-body">
                        <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Done</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END QR Code Modal -->
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            const tabMap = {
                'prevToPengukuran': '#btabs-animated-slideup-home-tab',
                'nextToStatus': '#btabs-animated-slideup-status-tab',
            };

            $.each(tabMap, function(buttonId, targetTabSelector) {
                $('#' + buttonId).on('click', function(e) {
                    e.preventDefault(); // ⛔️ Hindari reload/fallback
                    const $target = $(targetTabSelector);
                    if ($target.length) {
                        const tab = new bootstrap.Tab($target[0]);
                        tab.show();
                    } else {
                        console.warn('Target tab not found for:', targetTabSelector);
                    }
                });
            });
        });
    </script>
@endsection
