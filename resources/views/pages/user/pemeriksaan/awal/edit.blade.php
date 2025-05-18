@extends('layouts.base')

@section('header')
    <title>Pemeriksaan Awal</title>
@endsection

@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Table -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <div class="d-flex justify-content-between align-items-center w-100 flex-nowrap">
                    <h3 class="fs-3 fw-semibold my-2 mb-0">
                        Pemeriksaan Awal
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
                            <form action="{{ route('pemeriksaan-awal.update', $pemeriksaan->uuid) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <ul class="nav nav-tabs nav-tabs-block" role="tablist">
                                    <li class="nav-item">
                                        <button class="nav-link active" id="btabs-animated-slideup-home-tab"
                                            data-bs-toggle="tab" data-bs-target="#btabs-animated-slideup-home"
                                            role="tab" aria-controls="btabs-animated-slideup-home" aria-selected="true">
                                            <i class="fa fa-ruler"></i>
                                            Pengukuran
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" id="btabs-animated-slideup-profile-tab"
                                            data-bs-toggle="tab" data-bs-target="#btabs-animated-slideup-profile"
                                            role="tab" aria-controls="btabs-animated-slideup-profile"
                                            aria-selected="false">
                                            <i class="fa fa-virus"></i>
                                            Alergi
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" id="btabs-animated-slideup-status-tab"
                                            data-bs-toggle="tab" data-bs-target="#btabs-animated-slideup-status"
                                            role="tab" aria-controls="btabs-animated-slideup-status"
                                            aria-selected="false">
                                            <i class="fa fa-circle-check"></i>
                                            Status
                                        </button>
                                    </li>
                                </ul>
                                <div class="block-content tab-content overflow-hidden">
                                    <div class="tab-pane fade fade-up show active" id="btabs-animated-slideup-home"
                                        role="tabpanel" aria-labelledby="btabs-animated-slideup-home-tab" tabindex="0">
                                        <h4 class="fw-bolder">Pengukuran Pasien</h4>
                                        <div class="row col-12">
                                            <div class="col-6">
                                                <div class="row mb-2">
                                                    <label class="col-sm-5 col-form-label required">Nadi</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" name="nadi"
                                                            placeholder="input nadi" required autocomplete="off"
                                                            value="{{ $pemeriksaan->nadi ?? '' }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-sm-5 col-form-label required">Temperatur (°C)</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" name="temperatur"
                                                            placeholder="input temperatur" required autocomplete="off"
                                                            value="{{ $pemeriksaan->temperatur ?? '' }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-sm-5 col-form-label required">Tekanan Darah
                                                        (Systolic)</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control"
                                                            name="tekanan_darah_systolic"
                                                            placeholder="input tekanan darah systolic" required
                                                            autocomplete="off"
                                                            value="{{ $pemeriksaan->tekanan_darah_systolic ?? '' }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-sm-5 col-form-label required">Tekanan Darah
                                                        (Diastolic)</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control"
                                                            name="tekanan_darah_diastolic"
                                                            placeholder="input tekanan darah diastolic" required
                                                            autocomplete="off"
                                                            value="{{ $pemeriksaan->tekanan_darah_diastolic ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="row mb-2">
                                                    <label class="col-sm-5 col-form-label required">Pernapasan</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" name="napas"
                                                            placeholder="input pernapasan" required autocomplete="off"
                                                            value="{{ $pemeriksaan->napas ?? '' }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-sm-5 col-form-label required">Tinggi Badan
                                                        (cm)</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" name="tinggi_badan"
                                                            placeholder="input tinggi badan" required autocomplete="off"
                                                            value="{{ $pemeriksaan->tinggi_badan ?? '' }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-sm-5 col-form-label required">Berat Badan
                                                        (kg)</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" name="berat_badan"
                                                            placeholder="input berat badan" required autocomplete="off"
                                                            value="{{ $pemeriksaan->berat_badan ?? '' }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-sm-5 col-form-label required">Lingkar Perut
                                                        (cm)</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" name="lingkar_perut"
                                                            placeholder="input lingkar perut" required autocomplete="off"
                                                            value="{{ $pemeriksaan->lingkar_perut ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end mt-3">
                                            <button type="button" class="btn btn-lg btn-success" id="nextToAlergi">
                                                <i class="fa fa-arrow-right"></i>
                                                Next
                                            </button>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade fade-up" id="btabs-animated-slideup-profile"
                                        role="tabpanel" aria-labelledby="btabs-animated-slideup-profile-tab"
                                        tabindex="0">
                                        <h4 class="fw-bolder">Alergi Pasien</h4>
                                        <div class="row col-12">
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label required">Alergi Obat</label>
                                                <div class="col-sm-7">
                                                    <textarea class="form-control" rows="3" name="alergi_obat" placeholder="input alergi obat" required>{{ $pemeriksaan->pasien->alergi_obat ?? '-' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label required">Alergi Makanan</label>
                                                <div class="col-sm-7">
                                                    <textarea class="form-control" rows="3" name="alergi_makanan" placeholder="input alergi makanan" required>{{ $pemeriksaan->pasien->alergi_makanan ?? '-' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end mt-3">
                                            <button type="button" class="btn btn-lg btn-secondary me-2"
                                                id="prevToPengukuran">
                                                <i class="fa fa-arrow-left"></i>
                                                Back
                                            </button>
                                            <button type="button" class="btn btn-lg btn-success" id="nextToStatus">
                                                <i class="fa fa-arrow-right"></i>
                                                Next
                                            </button>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade fade-up" id="btabs-animated-slideup-status" role="tabpanel"
                                        aria-labelledby="btabs-animated-slideup-status-tab" tabindex="0">
                                        <h4 class="fw-bolder">Status Pemeriksaan Pasien</h4>
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
                                        </div>
                                        <div class="d-flex justify-content-end mt-3">
                                            <button type="button" class="btn btn-lg btn-secondary me-2"
                                                id="prevToAlergi">
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
            // Daftar ID tombol dan target tab-nya
            const tabMap = {
                'nextToAlergi': '#btabs-animated-slideup-profile-tab',
                'prevToPengukuran': '#btabs-animated-slideup-home-tab',
                'nextToSubjective': '#btabs-animated-slideup-subjective-tab',
                'prevToSubjective': '#btabs-animated-slideup-subjective-tab',
                'nextToAssessment': '#btabs-animated-slideup-assessment-tab',
                'prevToAssessment': '#btabs-animated-slideup-assessment-tab',
                'nextToPlan': '#btabs-animated-slideup-plan-tab',
                'prevToPlan': '#btabs-animated-slideup-plan-tab',
                'nextToStatus': '#btabs-animated-slideup-status-tab',
                'prevToAlergi': '#btabs-animated-slideup-profile-tab'
            };

            // Pasang event handler dengan loop
            $.each(tabMap, function(buttonId, targetTabSelector) {
                $('#' + buttonId).on('click', function() {
                    var triggerTab = new bootstrap.Tab($(targetTabSelector)[0]);
                    triggerTab.show();
                });
            });
        });
    </script>
@endsection
