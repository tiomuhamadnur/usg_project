@extends('layouts.base')

@section('header')
    <title>Riwayat Medis</title>
@endsection

@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Table -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <div class="d-flex justify-content-between align-items-center w-100 flex-nowrap">
                    <h3 class="fs-3 fw-semibold my-2 mb-0">
                        Data Riwayat Medis ({{ $pemeriksaan->pasien->name ?? 'N/A' }})
                    </h3>
                    <div class="row my-2 ms-1 gx-1">
                        <div class="col-12 col-md-auto mb-2 mb-md-0">
                            <div class="btn-group w-100 w-md-auto">
                                <button type="button" class="btn btn-secondary dropdown-toggle w-100"
                                    id="dropdown-default-primary" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fa fa-gear"></i>
                                    Action
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end w-100 w-md-auto"
                                    aria-labelledby="dropdown-default-primary">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)">
                                            <i class="fa fa-filter"></i> Filter
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal"
                                            data-bs-target="#exportModal">
                                            <i class="fa fa-file-export"></i> Export
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-md-auto">
                            <a href="{{ $prevURL }}" class="btn btn-danger">
                                <i class="fa fa-times me-1"></i> Batal
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="table-responsive">
                    {{ $dataTable->table([
                        'class' => 'table table-bordered table-striped table-vcenter table-sm fs-sm text-nowrap align-middle',
                    ]) }}
                </div>
            </div>
        </div>
        <!-- END Table -->
    </div>
    <!-- END Page Content -->
@endsection

@section('modals')
    <!-- Show Modal -->
    <div class="modal modal-blur fade" id="showModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content rounded-3 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Detail Pemeriksaan Awal</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mb-0">
                            <tbody id="modalDetailBody">
                                <!-- Content diisi via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-times me-1"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- END Show Modal -->
@endsection


@push('scripts')
    {{ $dataTable->scripts() }}
@endpush

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#showModal').on('show.bs.modal', function(e) {
                const button = $(e.relatedTarget); // tombol yang memicu modal
                const modalBody = $('#modalDetailBody');
                modalBody.empty(); // kosongkan isi sebelum render baru

                const dataMap = {
                    'name': 'Nama Pasien',
                    'gender': 'Jenis Kelamin',
                    'umur': 'Umur',
                    'tanggal-lahir': 'Tanggal Lahir',
                    'datetime': 'Tanggal Pemeriksaan',
                    'room': 'Ruangan',
                    'dokter': 'Dokter',
                    'rencana-pasien': 'Rencana Pasien',
                    'keluhan-pasien': 'Keluhan Pasien',
                    'alergi-obat': 'Alergi Obat',
                    'alergi-makanan': 'Alergi Makanan',
                    'nadi': 'Nadi',
                    'temperatur': 'Suhu Tubuh',
                    'napas': 'Frekuensi Napas',
                    'tekanan-darah-systolic': 'Tekanan Darah Sistolik',
                    'tekanan-darah-diastolic': 'Tekanan Darah Diastolik',
                    'tinggi-badan': 'Tinggi Badan',
                    'berat-badan': 'Berat Badan',
                    'lingkar-perut': 'Lingkar Perut',
                    'keluhan-utama': 'Keluhan Utama',
                    'keluhan-tambahan': 'Keluhan Tambahan',
                    'diagnosa-utama': 'Diagnosa Utama',
                    'diagnosa-sekunder': 'Diagnosa Sekunder',
                    'hasil-pemeriksaan': 'Hasil Pemeriksaan',
                    'terapi-obat': 'Terapi Obat',
                    'saran': 'Saran',
                    'resep-dokter': 'Resep Dokter',
                    'tindakan': 'Tindakan',
                    'rujukan': 'Rujukan'
                };

                $.each(dataMap, function(key, label) {
                    const value = button.data(key) ?? '-';
                    modalBody.append(`
                    <tr>
                        <th style="width: 40%;">${label}</th>
                        <td>${value}</td>
                    </tr>
                `);
                });
            });
        });
    </script>
@endsection
