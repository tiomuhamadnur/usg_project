@extends('layouts.base')

@section('header')
    <title>Kasir</title>
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
                    <a href="{{ route('kasir.index') }}" class="btn btn-secondary">
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
                                                <label class="col-sm-4 col-form-label required">Jenis Pelayanan</label>
                                                <div class="col-sm-7">
                                                    <table
                                                        class="table table-bordered table-striped table-vcenter table-sm fs-sm text-nowrap align-middle">
                                                        <thead>
                                                            <th class="text-center">No</th>
                                                            <th>Jenis Layanan</th>
                                                            <th>Harga (Rp.)</th>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($pemeriksaan->layanans as $item)
                                                                <tr>
                                                                    <td class="text-center">{{ $loop->iteration }}.</td>
                                                                    <td>{{ $item->layanan->name ?? 'N/A' }}</td>
                                                                    <td>{{ $item->layanan->harga ?? '0' }}</td>
                                                                </tr>
                                                            @endforeach
                                                            @if ($pemeriksaan->layanans->count() == 0)
                                                                <tr>
                                                                    <td class="text-center" colspan="3">Tidak ada
                                                                        layanan</td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label required">Terapi Obat</label>
                                                <div class="col-sm-7">
                                                    <table
                                                        class="table table-bordered table-striped table-vcenter table-sm fs-sm text-nowrap align-middle">
                                                        <thead>
                                                            <th class="text-center">No</th>
                                                            <th class="text-center">Konfirmasi</th>
                                                            <th>Nama Obat</th>
                                                            <th>Dosis</th>
                                                            <th>Aturan Pakai</th>
                                                            <th class="text-center">Jumlah</th>
                                                            <th>Harga Satuan (Rp.)</th>
                                                            <th>Sub Total (Rp.)</th>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($pemeriksaan->obats as $item)
                                                                <tr>
                                                                    <td class="text-center">{{ $loop->iteration }}.</td>
                                                                    <td class="text-center">
                                                                        <input class="form-check-input fs-3"
                                                                            type="checkbox" name="is_confirmed[]"
                                                                            value="1" id="is_confirmed">
                                                                        <input type="hidden" name="uuid[]"
                                                                            value="{{ $item->uuid }}">
                                                                    </td>
                                                                    <td>{{ $item->obat->name ?? 'N/A' }}
                                                                        ({{ $item->obat->sediaan->name ?? 'N/A' }})</td>
                                                                    <td>{{ $item->dosis ?? 'N/A' }}</td>
                                                                    <td>{{ $item->aturan_pakai ?? 'N/A' }}</td>
                                                                    <td class="text-center">{{ $item->jumlah ?? '-' }}
                                                                    </td>
                                                                    <td>{{ $item->obat->harga_jual ?? '0' }}</td>
                                                                    <td>{{ $item->obat->harga_jual * $item->jumlah }}</td>
                                                                </tr>
                                                            @endforeach
                                                            @if ($pemeriksaan->obats->count() == 0)
                                                                <tr>
                                                                    <td class="text-center" colspan="5">Tidak ada obat
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label required">Total Sebelum Diskon
                                                    (Rp.)</label>
                                                <div class="col-sm-7">
                                                    <input type="number" min="1" class="form-control"
                                                        name="total_bayar" id="total_bayar" autocomplete="off" required
                                                        placeholder="input total bayar" value="{{ $total_bayar }}"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label optional">Diskon</label>
                                                <div class="col-sm-7">
                                                    <select class="form-select" name="diskon_id" id="diskon_id">
                                                        <option value="" selected>Tidak ada</option>
                                                        @foreach ($diskon as $item)
                                                            <option value="{{ $item->id }}"
                                                                data-harga="{{ $item->harga ?? 0 }}">
                                                                {{ $item->name }} (Rp.{{ $item->harga ?? '0' }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-sm-4 col-form-label required"><b>Total Dibayar
                                                        (Rp.)</b></label>
                                                <div class="col-sm-7">
                                                    <input type="number" min="1" class="form-control"
                                                        id="total_dibayar" autocomplete="off"
                                                        placeholder="input total dibayar" value="{{ $total_bayar }}"
                                                        readonly>
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
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {

            // ================= TAB & VALIDATION (TETAP ADA) =================
            $('#btabs-animated-slideup-status-tab').prop('disabled', true);

            function validateTab(tabPaneId) {
                let isValid = true;
                $(tabPaneId).find('[required]').each(function() {
                    $(this).removeClass('is-invalid');
                    if ($(this).val() === null || $(this).val().trim() === '') {
                        isValid = false;
                        $(this).addClass('is-invalid');
                    }
                });

                if (!isValid) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data Belum Lengkap',
                        text: 'Mohon lengkapi semua kolom yang wajib diisi sebelum melanjutkan.',
                    });
                }
                return isValid;
            }

            $('form').on('input change', '.is-invalid', function() {
                $(this).removeClass('is-invalid');
            });

            $('#nextToStatus').on('click', function(e) {
                e.preventDefault();
                if (validateTab('#btabs-animated-slideup-home')) {
                    $('#btabs-animated-slideup-status-tab').prop('disabled', false);
                    new bootstrap.Tab($('#btabs-animated-slideup-status-tab')[0]).show();
                }
            });

            $('#prevToPengukuran').on('click', function(e) {
                e.preventDefault();
                new bootstrap.Tab($('#btabs-animated-slideup-home-tab')[0]).show();
            });

            // ================= HITUNG TOTAL =================

            const baseTotal = parseInt("{{ $total_bayar }}") || 0;

            const totalSebelumDiskonInput = document.getElementById('total_bayar');
            const totalDibayarInput = document.getElementById('total_dibayar');
            const diskonSelect = document.getElementById('diskon_id');

            function hitungTotalObat() {
                let totalObat = 0;

                document.querySelectorAll('input[name="is_confirmed[]"]').forEach(function(cb) {
                    if (cb.checked) {
                        const row = cb.closest('tr');
                        const subTotalCell = row.querySelector('td:nth-child(8)'); // SUB TOTAL

                        if (subTotalCell) {
                            totalObat += parseInt(subTotalCell.textContent) || 0;
                        }
                    }
                });

                return totalObat;
            }

            function updateTotal() {
                const totalObat = hitungTotalObat();
                const totalSebelumDiskon = baseTotal + totalObat;

                totalSebelumDiskonInput.value = totalSebelumDiskon;

                let diskon = 0;
                const selectedOption = diskonSelect.options[diskonSelect.selectedIndex];
                if (selectedOption) {
                    diskon = parseInt(selectedOption.dataset.harga) || 0;
                }

                let totalDibayar = totalSebelumDiskon - diskon;
                if (totalDibayar < 0) totalDibayar = 0;

                totalDibayarInput.value = totalDibayar;
            }

            // ================= EVENT =================
            document.querySelectorAll('input[name="is_confirmed[]"]').forEach(function(cb) {
                cb.addEventListener('change', updateTotal);
            });

            diskonSelect.addEventListener('change', updateTotal);

            updateTotal();
        });
    </script>
@endsection
