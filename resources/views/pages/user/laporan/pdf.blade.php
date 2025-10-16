<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <title>Laporan Pemeriksaan - {{ $pemeriksaan->code ?? 'N/A' }}</title>
        <!-- Icons -->
        <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png') }}">
        <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/favicons/favicon.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/favicon.png') }}">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <style>
            @page {
                margin: 25mm 5mm 20mm 5mm;
            }

            .header {
                position: fixed;
                top: -80px;
                left: 0px;
                right: 0px;
                height: 60px;
                text-align: left;
                line-height: 35px;
            }

            .footer {
                position: fixed;
                bottom: -60px;
                left: 0;
                right: 0;
                text-align: right;
                font-size: 12px;
                color: #555;
            }

            .page-break {
                page-break-after: always;
            }

            body {
                font-family: Arial, sans-serif;
                font-size: 12px;
            }

            .header {
                text-align: left;
                margin-bottom: 10px;
            }

            .header img {
                height: 70px;
            }

            .title {
                text-align: center;
                font-weight: bold;
                margin-bottom: 15px;
                font-size: 14px;
            }

            .signature {
                width: 100%;
                margin-top: 30px;
            }

            .signature td {
                text-align: center;
                padding: 5px;
            }

            .h-40 {
                height: 40px;
            }

            .h-70 {
                height: 70px;
            }

            .h-80 {
                height: 80px;
            }

            .h-90 {
                height: 90px;
            }

            .h-100 {
                height: 100px;
            }

            .h-15 {
                height: 15px;
            }

            .col-3 {
                width: 33%;
            }

            .table-outline {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 15px;
                border: 1px solid #000;
                /* hanya garis luar */
            }

            .table-outline th,
            .table-outline td {
                border: none;
                /* hilangkan border antar sel */
                padding: 6px;
                vertical-align: top;
            }
        </style>
    </head>

    <body>

        <div class="header">
            <img src="{{ public_path('media/favicons/favicon.png') }}" alt="Logo Klinik">
        </div>
        <div class="footer">
            <i> USGaja © {{ \Carbon\Carbon::now()->translatedFormat('Y') }} - (Dokumen ini dicetak pada {{ \Carbon\Carbon::now() }})</i>
        </div>

        <div class="title">
            LAPORAN PEMERIKSAAN PASIEN
        </div>

        <table class="table no-border">
            <tr>
                <td style="width: 150px"><b>No. Registrasi</b></td>
                <td class="font-weight-bold">: {{ $pemeriksaan->code ?? '-' }}</td>
            </tr>
            <tr>
                <td><b>Pasien</b></td>
                <td class="font-weight-bold">: {{ $pemeriksaan->pasien->name ?? '-' }}</td>
            </tr>
            <tr>
                <td><b>NIK</b></td>
                <td>: {{ $pemeriksaan->pasien->nik ?? '-' }}</td>
            </tr>
            <tr>
                <td><b>Dokter</b></td>
                <td>
                    : {{ $pemeriksaan->dokter->gelar_depan ?? '' }} {{ $pemeriksaan->dokter->name ?? '-' }}
                    {{ $pemeriksaan->dokter->gelar_belakang ?? '' }}
                </td>
            </tr>
            <tr>
                <td><b>Tanggal Pemeriksaan</b></td>
                <td>: {{ $pemeriksaan->datetime_pemeriksaan_awal ?? '-' }}</td>
            </tr>
        </table>

        <p><b>DATA VITAL:</b></p>
        <table class="table-outline">
            @if ($pemeriksaan->pasien->gender_id == 2)
                <tr>
                    <td style="width: 150px">HPHT</td>
                    <td>: {{ $pemeriksaan->pasien->hpht ?? '-' }}</td>
                </tr>
                <tr>
                    <td>GPA</td>
                    <td>:
                        G{{ $pemeriksaan->pasien->gravida ?? '-' }}P{{ $pemeriksaan->pasien->para ?? '-' }}A{{ $pemeriksaan->pasien->abortus ?? '-' }}
                    </td>
                </tr>
            @endif
            <tr>
                <td>Nadi</td>
                <td>: {{ $pemeriksaan->nadi ?? '-' }} bpm</td>
            </tr>
            <tr>
                <td>Temperatur</td>
                <td>: {{ $pemeriksaan->temperatur ?? '-' }} °C</td>
            </tr>
            <tr>
                <td>Napas</td>
                <td>: {{ $pemeriksaan->napas ?? '-' }} x/menit</td>
            </tr>
            <tr>
                <td>Tekanan Darah</td>
                <td>:
                    {{ $pemeriksaan->tekanan_darah_systolic ?? '-' }}/{{ $pemeriksaan->tekanan_darah_diastolic ?? '-' }}
                    mmHg</td>
            </tr>
            <tr>
                <td>Tinggi Badan</td>
                <td>: {{ $pemeriksaan->tinggi_badan ?? '-' }} cm</td>
            </tr>
            <tr>
                <td>Berat Badan</td>
                <td>: {{ $pemeriksaan->berat_badan ?? '-' }} kg</td>
            </tr>
            <tr>
                <td>Lingkar Perut</td>
                <td>: {{ $pemeriksaan->lingkar_perut ?? '-' }} cm</td>
            </tr>
        </table>

        <p><b>KELUHAN:</b></p>
        <table class="table-outline">
            <tr>
                <td style="width: 150px">Keluhan Utama</td>
                <td>: {{ $pemeriksaan->keluhan_utama ?? '-' }}</td>
            </tr>
            <tr>
                <td>Keluhan Tambahan</td>
                <td>: {{ $pemeriksaan->keluhan_tambahan ?? '-' }}</td>
            </tr>
            <tr>
                <td>Alergi Obat</td>
                <td>: {{ $pemeriksaan->alergi_obat ?? '-' }}</td>
            </tr>
            <tr>
                <td>Alergi Makanan</td>
                <td>: {{ $pemeriksaan->alergi_makanan ?? '-' }}</td>
            </tr>
        </table>

        <p><b>DIAGNOSA & HASIL:</b></p>
        <table class="table-outline">
            <tr>
                <td style="width: 150px;">Diagnosa Utama</td>
                <td>: {{ $pemeriksaan->diagnosa_utama ?? '-' }}</td>
            </tr>
            <tr>
                <td>Diagnosa Sekunder</td>
                <td>: {{ $pemeriksaan->diagnosa_sekunder ?? '-' }}</td>
            </tr>
            <tr>
                <td>Hasil Pemeriksaan</td>
                <td>: {{ $pemeriksaan->hasil_pemeriksaan ?? '-' }}</td>
            </tr>
        </table>

        <p><b>LAYANAN, TERAPI & SARAN:</b></p>
        <table class="table-outline">
            <tr>
                <td>Layanan</td>
                <td>:
                    <table style="border-collapse: collapse; width:100%; text-align:center">
                        <thead>
                            <tr>
                                <th style="border: 1px solid #000; padding: 5px; width: 20px;">No.</th>
                                <th style="border: 1px solid #000; padding: 5px;">Layanan</th>
                                <th style="border: 1px solid #000; padding: 5px;">Kategori</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($pemeriksaan->layanans->count() > 0)
                                @foreach ($pemeriksaan->layanans as $item)
                                    <tr>
                                        <td style="border: 1px solid #000; padding: 5px;">{{ $loop->iteration }}.</td>
                                        <td style="border: 1px solid #000; padding: 5px;">
                                            {{ $item->layanan->name ?? '-' }}
                                        </td>
                                        <td style="border: 1px solid #000; padding: 5px;">
                                            {{ $item->layanan->kategori->name ?? '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center" colspan="3">Tidak ada layanan</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="width: 150px">Terapi Obat</td>
                <td>:
                    <table style="border-collapse: collapse; width:100%;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid #000; padding: 5px;">No.</th>
                                <th style="border: 1px solid #000; padding: 5px;">Obat</th>
                                <th style="border: 1px solid #000; padding: 5px;">Jumlah</th>
                                <th style="border: 1px solid #000; padding: 5px;">Dosis</th>
                                <th style="border: 1px solid #000; padding: 5px;">Aturan</th>
                                <th style="border: 1px solid #000; padding: 5px;">Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($pemeriksaan->obats->count() > 0)
                                @foreach ($pemeriksaan->obats as $item)
                                    <tr>
                                        <td style="border: 1px solid #000; padding: 5px;">{{ $loop->iteration }}.</td>
                                        <td style="border: 1px solid #000; padding: 5px;">
                                            {{ $item->obat->name ?? '-' }}
                                        </td>
                                        <td style="border: 1px solid #000; padding: 5px;">{{ $item->jumlah ?? '-' }}
                                        </td>
                                        <td style="border: 1px solid #000; padding: 5px;">{{ $item->dosis ?? '-' }}
                                        </td>
                                        <td style="border: 1px solid #000; padding: 5px;">
                                            {{ $item->aturan_pakai ?? '-' }}
                                        </td>
                                        <td style="border: 1px solid #000; padding: 5px;">
                                            {{ $item->catatan_obat ?? '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center" colspan="6">Tidak ada obat</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                </td>
            </tr>
            <tr>
                <td>Saran</td>
                <td>: {{ $pemeriksaan->saran ?? '-' }}</td>
            </tr>
            {{-- <tr>
                <td>Resep Dokter</td>
                <td>: {{ $pemeriksaan->resep_dokter ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tindakan</td>
                <td>: {{ $pemeriksaan->tindakan ?? '-' }}</td>
            </tr>
            <tr>
                <td>Rujukan</td>
                <td>: {{ $pemeriksaan->rujukan ?? '-' }}</td>
            </tr> --}}
        </table>

        <p><b>PEMBAYARAN:</b></p>
        <table class="table-outline">
            <tr>
                <td style="width: 150px">Total Bayar</td>
                <td>: Rp. {{ number_format($pemeriksaan->total_bayar ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Metode Pembayaran</td>
                <td>: {{ $pemeriksaan->metode_pembayaran->name ?? '-' }}</td>
            </tr>
            <tr>
                <td>Status Pembayaran</td>
                <td>: {{ $pemeriksaan->status_pembayaran->name ?? '-' }}</td>
            </tr>
        </table>

        <table class="table signature">
            <tr>
                <td class="col-3"></td>
                <td class="col-3"></td>
                <td class="col-3">Dokter Pemeriksa,</td>
            </tr>
            <tr>
                <td class="h-100"></td>
                <td class="h-100"></td>
                <td class="h-100"></td>
            </tr>
            <tr>
                <td class="h-15"></td>
                <td class="h-15"></td>
                <td class="h-15 font-weight-bold" style="border-bottom:1pt solid black;"><b>
                        {{ $pemeriksaan->dokter->gelar_depan ?? '' }} {{ $pemeriksaan->dokter->name ?? '' }}
                        {{ $pemeriksaan->dokter->gelar_belakang ?? '' }}</b>
                </td>
            </tr>
        </table>
    </body>

</html>
