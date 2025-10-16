@extends('layouts.base')

@section('header')
    <title>Pemeriksaan Dokter</title>
@endsection

@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Table -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <div class="d-flex justify-content-between align-items-center w-100 flex-nowrap">
                    <h3 class="fs-3 fw-semibold my-2 mb-0">
                        Pemeriksaan Dokter
                    </h3>
                    <a href="{{ route('pemeriksaan-dokter.index') }}" class="btn btn-danger">
                        <i class="fa fa-times me-1"></i> Batal
                    </a>
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
                                        Barcode
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
                        {{-- <div class="row mb-2">
                            <label class="col-sm-3 col-form-label">Ruangan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" disabled value="{{ $pemeriksaan->room->name }}">
                            </div>
                        </div> --}}
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label">Alamat</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" disabled rows="2">{{ $pemeriksaan->pasien->alamat }}, {{ $pemeriksaan->pasien->kelurahan->name }}, {{ $pemeriksaan->pasien->kecamatan->name }}, {{ $pemeriksaan->pasien->kota->name }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label">Riwayat Medis</label>
                            <div class="col-sm-8">
                                <a href="{{ route('pemeriksaan-dokter.show', $pemeriksaan->uuid ?? '') }}" target="_blank"
                                    class="btn btn-primary">
                                    <i class="fa fa-rectangle-list"></i>
                                    Lihat Riwayat
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row border border-2 mt-3">
                    <div class="col-lg-12">
                        <!-- Block Tabs Animated Slide Up -->
                        <div class="block block-rounded">
                            <form action="{{ route('pemeriksaan-dokter.update', $pemeriksaan->uuid) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <ul class="nav nav-tabs nav-tabs-block" role="tablist">
                                    <li class="nav-item">
                                        <button class="nav-link" id="btabs-animated-slideup-home-tab" data-bs-toggle="tab"
                                            data-bs-target="#btabs-animated-slideup-home" role="tab"
                                            aria-controls="btabs-animated-slideup-home" aria-selected="true">
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
                                        <button class="nav-link active" id="btabs-animated-slideup-subjective-tab"
                                            data-bs-toggle="tab" data-bs-target="#btabs-animated-slideup-subjective"
                                            role="tab" aria-controls="btabs-animated-slideup-subjective"
                                            aria-selected="false">
                                            <i class="fa fa-user"></i>
                                            Subjective
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" id="btabs-animated-slideup-assessment-tab"
                                            data-bs-toggle="tab" data-bs-target="#btabs-animated-slideup-assessment"
                                            role="tab" aria-controls="btabs-animated-slideup-assessment"
                                            aria-selected="false">
                                            <i class="fa fa-pencil"></i>
                                            Assessment
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" id="btabs-animated-slideup-plan-tab"
                                            data-bs-toggle="tab" data-bs-target="#btabs-animated-slideup-plan"
                                            role="tab" aria-controls="btabs-animated-slideup-plan"
                                            aria-selected="false">
                                            <i class="fa fa-paper-plane"></i>
                                            Plan
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" id="btabs-animated-slideup-pelayanan-tab"
                                            data-bs-toggle="tab" data-bs-target="#btabs-animated-slideup-pelayanan"
                                            role="tab" aria-controls="btabs-animated-slideup-pelayanan"
                                            aria-selected="false">
                                            <i class="fa fa-heart"></i>
                                            Pelayanan
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
                                    {{-- Start Pengukuran --}}
                                    <div class="tab-pane fade fade-up" id="btabs-animated-slideup-home" role="tabpanel"
                                        aria-labelledby="btabs-animated-slideup-home-tab" tabindex="0">
                                        <h4 class="fw-bolder">Pengukuran Pasien</h4>
                                        <div class="row col-12">
                                            <div class="col-6">
                                                <div class="row mb-2">
                                                    <label class="col-sm-5 col-form-label">Nadi</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" name="nadi"
                                                            placeholder="input nadi" autocomplete="off"
                                                            value="{{ $pemeriksaan->nadi ?? '' }}" disabled>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-sm-5 col-form-label">Temperatur (°C)</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" name="temperatur"
                                                            placeholder="input temperatur" autocomplete="off"
                                                            value="{{ $pemeriksaan->temperatur ?? '' }}" disabled>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-sm-5 col-form-label">Tekanan Darah
                                                        (Systolic)</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control"
                                                            name="tekanan_darah_systolic"
                                                            placeholder="input tekanan darah systolic" autocomplete="off"
                                                            value="{{ $pemeriksaan->tekanan_darah_systolic ?? '' }}"
                                                            disabled>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-sm-5 col-form-label">Tekanan Darah
                                                        (Diastolic)</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control"
                                                            name="tekanan_darah_diastolic"
                                                            placeholder="input tekanan darah diastolic" autocomplete="off"
                                                            value="{{ $pemeriksaan->tekanan_darah_diastolic ?? '' }}"
                                                            disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="row mb-2">
                                                    <label class="col-sm-5 col-form-label">Pernapasan</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" name="napas"
                                                            placeholder="input pernapasan" autocomplete="off"
                                                            value="{{ $pemeriksaan->napas ?? '' }}" disabled>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-sm-5 col-form-label">Tinggi Badan
                                                        (cm)</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" name="tinggi_badan"
                                                            placeholder="input tinggi badan" autocomplete="off"
                                                            value="{{ $pemeriksaan->tinggi_badan ?? '' }}" disabled>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-sm-5 col-form-label">Berat Badan
                                                        (kg)</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" name="berat_badan"
                                                            placeholder="input berat badan" autocomplete="off"
                                                            value="{{ $pemeriksaan->berat_badan ?? '' }}" disabled>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-sm-5 col-form-label">Lingkar Perut
                                                        (cm)</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" name="lingkar_perut"
                                                            placeholder="input lingkar perut" autocomplete="off"
                                                            value="{{ $pemeriksaan->lingkar_perut ?? '' }}" disabled>
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
                                    {{-- End Pengukuran --}}

                                    {{-- Start Alergi --}}
                                    <div class="tab-pane fade fade-up" id="btabs-animated-slideup-profile"
                                        role="tabpanel" aria-labelledby="btabs-animated-slideup-profile-tab"
                                        tabindex="0">
                                        <h4 class="fw-bolder">Alergi Pasien</h4>
                                        <div class="row col-12">
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label">Alergi Obat</label>
                                                <div class="col-sm-7">
                                                    <textarea class="form-control" rows="3" name="alergi_obat" placeholder="input alergi obat" disabled>{{ $pemeriksaan->pasien->alergi_obat ?? '-' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label">Alergi Makanan</label>
                                                <div class="col-sm-7">
                                                    <textarea class="form-control" rows="3" name="alergi_makanan" placeholder="input alergi makanan" disabled>{{ $pemeriksaan->pasien->alergi_makanan ?? '-' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end mt-3">
                                            <button type="button" class="btn btn-lg btn-secondary me-2"
                                                id="prevToPengukuran">
                                                <i class="fa fa-arrow-left"></i>
                                                Back
                                            </button>
                                            <button type="button" class="btn btn-lg btn-success" id="nextToSubjective">
                                                <i class="fa fa-arrow-right"></i>
                                                Next
                                            </button>
                                        </div>
                                    </div>
                                    {{-- End Alergi --}}

                                    {{-- Start Subjective --}}
                                    <div class="tab-pane fade fade-up show active" id="btabs-animated-slideup-subjective"
                                        role="tabpanel" aria-labelledby="btabs-animated-slideup-subjective-tab"
                                        tabindex="0">
                                        <h4 class="fw-bolder">Subjective Pasien</h4>
                                        <div class="row col-12">
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label">Rencana Pasien</label>
                                                <div class="col-sm-7">
                                                    <textarea class="form-control" rows="3" placeholder="input rencana pasien" disabled>{{ $pemeriksaan->rencana_pasien ?? '-' }}</textarea>
                                                </div>
                                            </div>
                                            @if ($pemeriksaan->pasien->gender_id == 2)
                                                <div class="row mb-2">
                                                    <label class="col-sm-4 col-form-label optional">HPHT</label>
                                                    <div class="col-sm-7">
                                                        <input type="date" class="form-control" name="hpht"
                                                            id="hpht" autocomplete="off"
                                                            value="{{ $pemeriksaan->pasien->hpht ?? null }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-sm-4 col-form-label optional">Riwayat Kehamilan</label>
                                                    <div class="col-sm-7">
                                                        <div class="row g-2">
                                                            <div class="col-12 col-md-4">
                                                                <div class="input-group">
                                                                    <input type="number" class="form-control" min="0"
                                                                        name="gravida" id="gravida"
                                                                        value="{{ old('gravida', $pemeriksaan->pasien->gravida ?? '0') }}"
                                                                        autocomplete="off">
                                                                    <span class="input-group-text">G (Gravida)</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-4">
                                                                <div class="input-group">
                                                                    <input type="number" class="form-control" min="0"
                                                                        name="para" id="para"
                                                                        value="{{ old('para', $pemeriksaan->pasien->para ?? '0') }}"
                                                                        autocomplete="off">
                                                                    <span class="input-group-text">P (Para)</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-4">
                                                                <div class="input-group">
                                                                    <input type="number" class="form-control" min="0"
                                                                        name="abortus" id="abortus"
                                                                        value="{{ old('abortus', $pemeriksaan->pasien->abortus ?? '0') }}"
                                                                        autocomplete="off">
                                                                    <span class="input-group-text">A (Abortus)</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label required">Keluhan Utama</label>
                                                <div class="col-sm-7">
                                                    <textarea class="form-control" rows="3" name="keluhan_utama" placeholder="input keluhan utama" required>{{ $pemeriksaan->keluhan_utama ?? $pemeriksaan->keluhan_pasien }}</textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label required">Keluhan Tambahan</label>
                                                <div class="col-sm-7">
                                                    <textarea class="form-control" rows="3" name="keluhan_tambahan"
                                                        placeholder="input keluhan tambahan (isi '-' jika tidak ada)" required>{{ $pemeriksaan->keluhan_tambahan }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end mt-3">
                                            <button type="button" class="btn btn-lg btn-secondary me-2"
                                                id="prevToAlergi">
                                                <i class="fa fa-arrow-left"></i>
                                                Back
                                            </button>
                                            <button type="button" class="btn btn-lg btn-success" id="nextToAssessment">
                                                <i class="fa fa-arrow-right"></i>
                                                Next
                                            </button>
                                        </div>
                                    </div>
                                    {{-- End Subjective --}}

                                    {{-- Start Assessment --}}
                                    <div class="tab-pane fade fade-up" id="btabs-animated-slideup-assessment"
                                        role="tabpanel" aria-labelledby="btabs-animated-slideup-assessment-tab"
                                        tabindex="0">
                                        <h4 class="fw-bolder">Assessment Pasien</h4>
                                        <div class="row col-12">
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label required">Diagnosa Utama</label>
                                                <div class="col-sm-7">
                                                    <textarea class="form-control" rows="3" name="diagnosa_utama" placeholder="input diagnosa utama" required>{{ $pemeriksaan->diagnosa_utama }}</textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label required">Diagnosa Sekunder</label>
                                                <div class="col-sm-7">
                                                    <textarea class="form-control" rows="3" name="diagnosa_sekunder" placeholder="input diagnosa sekunder"
                                                        required>{{ $pemeriksaan->diagnosa_sekunder }}</textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label required">Hasil Pemeriksaan</label>
                                                <div class="col-sm-7">
                                                    <textarea class="form-control" rows="3" name="hasil_pemeriksaan" placeholder="input hasil pemeriksaan"
                                                        required>{{ $pemeriksaan->hasil_pemeriksaan }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end mt-3">
                                            <button type="button" class="btn btn-lg btn-secondary me-2"
                                                id="prevToSubjective">
                                                <i class="fa fa-arrow-left"></i>
                                                Back
                                            </button>
                                            <button type="button" class="btn btn-lg btn-success" id="nextToPlan">
                                                <i class="fa fa-arrow-right"></i>
                                                Next
                                            </button>
                                        </div>
                                    </div>
                                    {{-- End Assessment --}}

                                    {{-- Start Plan --}}
                                    <div class="tab-pane fade fade-up" id="btabs-animated-slideup-plan" role="tabpanel"
                                        aria-labelledby="btabs-animated-slideup-plan-tab" tabindex="0">
                                        <h4 class="fw-bolder">Plan Pasien</h4>
                                        <div class="row col-12">
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label required">Saran/Kunjungan
                                                    berikutnya</label>
                                                <div class="col-sm-7">
                                                    <textarea class="form-control" rows="3" name="saran" placeholder="input saran/kunjungan berikutnya"
                                                        required>{{ $pemeriksaan->saran }}</textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label optional">Terapi Obat</label>
                                                {{-- <div class="col-sm-7">
                                                    <textarea class="form-control" rows="3" name="terapi_obat" placeholder="input terapi obat" required>{{ $pemeriksaan->terapi_obat }}</textarea>
                                                </div> --}}
                                                <div class="col-sm-7 mb-2">
                                                    <button type="submit" class="btn btn-sm btn-primary"
                                                        data-bs-toggle="modal" data-bs-target="#addObatModal">
                                                        <i class="fa fa-plus"></i>
                                                        Tambah Terapi Obat
                                                    </button>
                                                    <div class="col-sm-7 mt-3">
                                                        <table
                                                            class="table table-bordered table-striped table-vcenter table-sm fs-sm text-nowrap align-middle">
                                                            <thead>
                                                                <th class="text-center">No</th>
                                                                <th>Obat</th>
                                                                <th class="text-center">Jumlah</th>
                                                                <th class="text-center">Dosis</th>
                                                                <th>Aturan Pakai</th>
                                                                <th>Catatan Obat</th>
                                                                <th class="text-center">#</th>
                                                            </thead>
                                                            <tbody>
                                                                @if ($pemeriksaan->obats->count() > 0)
                                                                    @foreach ($pemeriksaan->obats as $item)
                                                                        <tr>
                                                                            <td class="text-center">
                                                                                {{ $loop->iteration }}.</td>
                                                                            <td class="text-center">
                                                                                <input type="hidden" name="obat_id[]" value="{{ $item->obat->id }}" required>
                                                                                {{ $item->obat->name ?? 'N/A' }}</td>
                                                                            <td class="text-center">
                                                                                <input type="hidden" name="jumlah[]" value="{{ $item->jumlah }}" required>
                                                                                {{ $item->jumlah ?? '0' }}</td>
                                                                            <td class="text-center">
                                                                                <input type="hidden" name="dosis[]" value="{{ $item->dosis }}" required>
                                                                                {{ $item->dosis ?? 'N/A' }}</td>
                                                                            <td>
                                                                                <input type="hidden" name="aturan_pakai[]" value="{{ $item->aturan_pakai }}" required>
                                                                                {{ $item->aturan_pakai ?? 'N/A' }}
                                                                            </td>
                                                                            <td>
                                                                                <input type="hidden" name="catatan_obat[]" value="{{ $item->catatan_obat }}" required>
                                                                                {{ $item->catatan_obat ?? 'N/A' }}
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <button type="button"
                                                                                    class="btn btn-sm btn-danger btn-delete-obat">
                                                                                    <i class="fa fa-trash"></i>
                                                                                </button>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end mt-3">
                                            <button type="button" class="btn btn-lg btn-secondary me-2"
                                                id="prevToAssessment">
                                                <i class="fa fa-arrow-left"></i>
                                                Back
                                            </button>
                                            <button type="button" class="btn btn-lg btn-success" id="nextToPelayanan">
                                                <i class="fa fa-arrow-right"></i>
                                                Next
                                            </button>
                                        </div>
                                    </div>
                                    {{-- End Plan --}}

                                    {{-- Start Pelayanan --}}
                                    <div class="tab-pane fade fade-up" id="btabs-animated-slideup-pelayanan"
                                        role="tabpanel" aria-labelledby="btabs-animated-slideup-pelayanan-tab"
                                        tabindex="0">
                                        <h4 class="fw-bolder">Pelayanan</h4>
                                        <div class="row col-12">
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label required">Jenis Pelayanan</label>
                                                <div class="col-sm-7 mb-2">
                                                    <button type="submit" class="btn btn-sm btn-primary"
                                                        data-bs-toggle="modal" data-bs-target="#addLayananModal">
                                                        <i class="fa fa-plus"></i>
                                                        Tambah Jenis Pelayanan
                                                    </button>
                                                    <div class="col-sm-7 mt-3">
                                                        <table
                                                            class="table table-bordered table-striped table-vcenter table-sm fs-sm text-nowrap align-middle">
                                                            <thead>
                                                                <th class="text-center">No</th>
                                                                <th>Jenis Layanan</th>
                                                                <th class="text-center">#</th>
                                                            </thead>
                                                            <tbody>
                                                                @if ($pemeriksaan->layanans->count() > 0)
                                                                    @foreach ($pemeriksaan->layanans as $item)
                                                                        <tr>
                                                                            <td class="text-center">
                                                                                {{ $loop->iteration }}.</td>
                                                                            <td class="text-center">
                                                                                <input type="hidden" name="layanan_id[]" value="{{ $item->layanan->id }}" required>
                                                                                {{ $item->layanan->name ?? 'N/A' }}</td>
                                                                            <td class="text-center">
                                                                                <button type="button"
                                                                                    class="btn btn-sm btn-danger btn-delete-obat">
                                                                                    <i class="fa fa-trash"></i>
                                                                                </button>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end mt-3">
                                            <button type="button" class="btn btn-lg btn-secondary me-2" id="prevToPlan">
                                                <i class="fa fa-arrow-left"></i>
                                                Back
                                            </button>
                                            <button type="button" class="btn btn-lg btn-success" id="nextToStatus">
                                                <i class="fa fa-arrow-right"></i>
                                                Next
                                            </button>
                                        </div>
                                    </div>
                                    {{-- End Pelayanan --}}

                                    {{-- Start Status --}}
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
                                                id="prevToPelayanan">
                                                <i class="fa fa-arrow-left"></i>
                                                Back
                                            </button>
                                            <button type="submit" class="btn btn-lg btn-primary">
                                                <i class="fa fa-floppy-disk"></i>
                                                Simpan
                                            </button>
                                        </div>
                                    </div>
                                    {{-- End Pelayanan --}}
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
                    <div class="block-header bg-primary">
                        <h3 class="block-title text-white">Kode Registrasi</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="text-center">
                            <img class="img img-thumbnail" style="width: 80%;" id="qrcode_img"
                                src="data:image/png;base64,{{ $pemeriksaan->qr_code }}" alt="QR-code">
                            <h1 class="mt-2 fw-bolder">{{ $pemeriksaan->code }}</h1>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-end bg-body">
                        <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END QR Code Modal -->

    <!-- Add Obat Modal -->
    <div class="modal modal-blur fade" id="addObatModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-fromleft" role="document">
            <div class="modal-content">
                <form action="#" method="POST">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white">Tambah Obat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @livewire('form-obat-dokter')
                        <div class="mb-3">
                            <label class="form-label required" for="dosis">Dosis</label>
                            <select class="form-select" name="dosis" id="dosis" required>
                                <option value="" disabled selected>- pilih dosis -</option>
                                @foreach ($dosis as $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="aturan_pakai">Aturan Pakai</label>
                            <select class="form-select" name="aturan_pakai" id="aturan_pakai" required>
                                <option value="" disabled selected>- pilih aturan pakai -</option>
                                @foreach ($aturan_pakai as $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label optional" for="catatan_obat">Catatan Obat</label>
                            <textarea class="form-control" name="catatan_obat" id="catatan_obat" placeholder="input catatan obat" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto">
                            <i class="fa fa-plus"></i>
                            Tambah
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END Add Obat Modal -->

    <!-- Add Layanan Modal -->
    <div class="modal modal-blur fade" id="addLayananModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-fromleft" role="document">
            <div class="modal-content">
                <form action="#" method="POST">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white">Tambah Pelayanan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label required" for="layanan_id">Jenis Pelayanan</label>
                            <select class="form-select" name="layanan_id" id="layanan_id" required>
                                <option value="" disabled selected>- pilih jenis pelayanan -</option>
                                @foreach ($layanan as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}
                                        ({{ $item->kategori->name ?? 'N/A' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto">
                            <i class="fa fa-plus"></i>
                            Tambah
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END Add Layanan Modal -->
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            // --- SETUP ---
            // Simpan semua tombol tab dalam sebuah array untuk kemudahan pengelolaan
            const tabButtons = [
                '#btabs-animated-slideup-home-tab',
                '#btabs-animated-slideup-profile-tab',
                '#btabs-animated-slideup-subjective-tab',
                '#btabs-animated-slideup-assessment-tab',
                '#btabs-animated-slideup-plan-tab',
                '#btabs-animated-slideup-pelayanan-tab', // <-- Tab Pelayanan ada di sini (index 5)
                '#btabs-animated-slideup-status-tab'
            ];

            /**
             * Mengupdate status disabled pada semua tab.
             * Hanya tab sampai 'activeIndex' yang akan aktif, sisanya akan dinonaktifkan.
             * @param {number} activeIndex Indeks dari tab yang saat ini aktif.
             */
            function updateTabStates(activeIndex) {
                tabButtons.forEach((tabId, index) => {
                    // Selama index tab (misal: Pelayanan di index 5) lebih besar dari activeIndex (Subjective di index 2),
                    // maka tab tersebut akan di-disable.
                    if (index > activeIndex && index >= 3) { // <-- LOGIKA INI PENYEBABNYA
                        $(tabId).prop('disabled', true);
                    } else {
                        $(tabId).prop('disabled', false);
                    }
                });
            }

            /**
             * Memvalidasi semua field yang 'required' di dalam sebuah tab pane.
             * @param {string} tabPaneId ID dari tab pane yang akan divalidasi.
             * @returns {boolean} True jika valid, false jika tidak.
             */
            function validateTab(tabPaneId) {
                let isValid = true;
                const $tabPane = $(tabPaneId);

                $tabPane.find('[required]').each(function() {
                    $(this).removeClass('is-invalid');
                    if ($(this).val() === null || $(this).val().trim() === '') {
                        isValid = false;
                        $(this).addClass('is-invalid');
                    }
                });

                // 🔴 Tambahan khusus untuk tab pelayanan
                if (tabPaneId === '#btabs-animated-slideup-pelayanan') {
                    const layananCount = $tabPane.find('table tbody tr').length;
                    if (layananCount === 0) {
                        isValid = false;
                        Swal.fire({
                            icon: 'warning',
                            title: 'Belum ada layanan',
                            text: 'Silakan pilih minimal satu jenis pelayanan sebelum melanjutkan.',
                            confirmButtonColor: '#3085d6',
                        });
                    }
                }

                if (!isValid && tabPaneId !== '#btabs-animated-slideup-pelayanan') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data Belum Lengkap',
                        text: 'Mohon lengkapi semua kolom yang wajib diisi sebelum melanjutkan.',
                        confirmButtonColor: '#3085d6',
                    });
                }

                return isValid;
            }

            // --- INITIAL STATE ---
            // 1. Dapatkan index tab yang aktif saat halaman dimuat ('Subjective' adalah index 2).
            const initialActiveIndex = tabButtons.indexOf('#' + $('.nav-tabs-block .nav-link.active').attr('id'));

            // 2. Panggil fungsi updateTabStates dengan index 2.
            // Fungsi ini akan menonaktifkan semua tab setelah index 2, TERMASUK 'Pelayanan'.
            updateTabStates(initialActiveIndex);

            // Tambahkan listener untuk event 'show.bs.tab'
            $('.nav-tabs-block .nav-link').on('show.bs.tab', function(e) {
                const activeTabId = $(e.target).attr('id');
                const activeIndex = tabButtons.indexOf('#' + activeTabId);
                updateTabStates(activeIndex);
            });

            // Hapus class 'is-invalid' saat pengguna mulai mengisi form
            $('form').on('input change', '.is-invalid', function() {
                $(this).removeClass('is-invalid');
            });

            // --- TAB NAVIGATION HANDLERS ---
            function navigateToTab(buttonSelector, validationPaneId, targetTabSelector) {
                $(buttonSelector).on('click', function(e) {
                    e.preventDefault();
                    if (!validationPaneId || validateTab(validationPaneId)) {
                        const triggerTab = new bootstrap.Tab($(targetTabSelector)[0]);
                        triggerTab.show();
                    }
                });
            }

            // Navigasi Read-only (tanpa validasi)
            navigateToTab('#nextToAlergi', null, '#btabs-animated-slideup-profile-tab');
            navigateToTab('#nextToSubjective', null, '#btabs-animated-slideup-subjective-tab');
            navigateToTab('#prevToPengukuran', null, '#btabs-animated-slideup-home-tab');
            navigateToTab('#prevToAlergi', null, '#btabs-animated-slideup-profile-tab');

            // Navigasi dengan Validasi
            navigateToTab('#nextToAssessment', '#btabs-animated-slideup-subjective',
                '#btabs-animated-slideup-assessment-tab');
            navigateToTab('#nextToPlan', '#btabs-animated-slideup-assessment', '#btabs-animated-slideup-plan-tab');
            navigateToTab('#nextToPelayanan', '#btabs-animated-slideup-plan',
                '#btabs-animated-slideup-pelayanan-tab');
            navigateToTab('#nextToStatus', '#btabs-animated-slideup-pelayanan',
                '#btabs-animated-slideup-status-tab');

            // Navigasi Mundur dari Tab Validasi
            navigateToTab('#prevToSubjective', null, '#btabs-animated-slideup-subjective-tab');
            navigateToTab('#prevToAssessment', null, '#btabs-animated-slideup-assessment-tab');
            navigateToTab('#prevToPlan', null, '#btabs-animated-slideup-plan-tab');
            navigateToTab('#prevToPelayanan', null, '#btabs-animated-slideup-pelayanan-tab');


            // --- PELAYANAN HANDLER ---
            // Saat pilih layanan di select
            $('#layanan_id').on('change', function() {
                const layananId = $(this).val();
                const layananName = $(this).find('option:selected').text();

                if (!layananId) return; // belum pilih

                const $tableBody = $('#btabs-animated-slideup-pelayanan table tbody');

                // --- CEK DUPLIKAT ---
                let isDuplicate = false;
                $tableBody.find('input[name="layanan_id[]"]').each(function() {
                    if ($(this).val() === layananId) {
                        isDuplicate = true;
                        return false; // stop loop
                    }
                });

                if (isDuplicate) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Layanan sudah ada',
                        text: 'Jenis pelayanan ini sudah ditambahkan ke tabel.',
                        confirmButtonColor: '#3085d6',
                    });
                    // reset select & jangan tutup modal
                    $(this).val('');
                    return;
                }

                // hitung nomor urut
                const rowCount = $tableBody.find('tr').length + 1;

                // buat row baru
                const newRow = `
                    <tr>
                        <td class="text-center">${rowCount}.</td>
                        <td>
                            <input type="hidden" name="layanan_id[]" value="${layananId}" required>
                            ${layananName}
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-danger btn-delete">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;

                $tableBody.append(newRow);

                // reset select
                $(this).val('');

                // tutup modal (Bootstrap 5 API)
                const modalEl = document.getElementById('addLayananModal');
                const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                modal.hide();
            });

            // hapus row layanan
            $(document).on('click', '.btn-delete', function() {
                $(this).closest('tr').remove();

                // update nomor urut
                $('#btabs-animated-slideup-pelayanan table tbody tr').each(function(i) {
                    $(this).find('td:first').text((i + 1) + '.');
                });
            });



            // --- OBAT HANDLER ---
            $('#addObatModal form').on('submit', function(e) {
                e.preventDefault();

                const obatId = $('#obat_id').val();
                const obatName = $('#obat_id option:selected').text();
                const jumlah = $('#jumlah').val();
                const dosis = $('#dosis').val();
                const aturanPakai = $('#aturan_pakai').val();
                const catatanObat = $('#catatan_obat').val();

                if (!obatId) return;

                const $tableBody = $('#btabs-animated-slideup-plan table tbody');

                // --- CEK DUPLIKAT OBAT ---
                let isDuplicate = false;
                $tableBody.find('input[name="obat_id[]"]').each(function() {
                    if ($(this).val() === obatId) {
                        isDuplicate = true;
                        return false;
                    }
                });

                if (isDuplicate) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Obat sudah ada',
                        text: 'Obat ini sudah ditambahkan ke tabel.',
                        confirmButtonColor: '#3085d6',
                    });
                    return;
                }

                // hitung nomor urut
                const rowCount = $tableBody.find('tr').length + 1;

                // buat row baru
                const newRow = `
                    <tr>
                        <td class="text-center">${rowCount}.</td>
                        <td>
                            <input type="hidden" name="obat_id[]" value="${obatId}" required>
                            ${obatName}
                        </td>
                        <td class="text-center">
                            <input type="hidden" name="jumlah[]" value="${jumlah}" required>
                            ${jumlah}
                        </td>
                        <td class="text-center">
                            <input type="hidden" name="dosis[]" value="${dosis}" required>
                            ${dosis}
                        </td>
                        <td>
                            <input type="hidden" name="aturan_pakai[]" value="${aturanPakai}" required>
                            ${aturanPakai}
                        </td>
                        <td>
                            <input type="hidden" name="catatan_obat[]" value="${catatanObat}">
                            ${catatanObat}
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-danger btn-delete-obat">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;

                $tableBody.append(newRow);

                // reset form modal
                $('#addObatModal form')[0].reset();

                // tutup modal (Bootstrap 5 API)
                const modalEl = document.getElementById('addObatModal');
                const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                modal.hide();
            });

            // hapus row obat
            $(document).on('click', '.btn-delete-obat', function() {
                $(this).closest('tr').remove();

                // update nomor urut
                $('#btabs-animated-slideup-plan table tbody tr').each(function(i) {
                    $(this).find('td:first').text((i + 1) + '.');
                });
            });


        });
    </script>
@endsection
